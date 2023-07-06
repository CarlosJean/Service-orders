<?php

namespace App\Repositories;

use App\Exceptions\NoServiceOrderItemsException;
use App\Exceptions\NotFoundModelException;
use App\Models\Employee;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemsDetail;
use App\Models\User;
use App\Notifications\ServiceOrderCreated;
use App\Notifications\ServiceOrderItemRequest;
use App\Notifications\ServiceOrderItemsRequestApproved;
use App\Notifications\TechnicianAssigned;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class OrdersRepository
{

    protected $employeeRepository;
    protected $itemsRepository;
    public function __construct(EmployeeRepository $employeeRepository, ItemsRepository $itemsRepository)
    {
        $this->employeeRepository = $employeeRepository;
        $this->itemsRepository = $itemsRepository;
    }

    public function orderNumber()
    {
        //!TODO: Determinar si el número de orden está repetido.

        return $this->generateOrderNumber();
    }

    private function generateOrderNumber()
    {
        $minOrderNumber = 000000;
        $maxOrderNumber = 999999;

        return rand($minOrderNumber, $maxOrderNumber);
    }

    public function createOrder($issue, $orderNumber)
    {
        try {

            if ($issue == null) {
                throw new Exception('Debe especificar un inconveniente.', 1);
            }

            $requestorId = auth()->id();
            $order = new Order([
                'requestor' => $requestorId,
                'number' => $orderNumber,
                'issue' => $issue,
                'status' => 'pendiente de asignar tecnico'
            ]);

            $order->save();

            //Notificar al supervisor y gerente del departamento de mantenimiento
            $maintenanceSupervisors = Employee::get()
                ->whereIn('role_id', [2, 3])
                ->where('department_id', 2);

            $requestor = User::find($requestorId)->name;
            foreach ($maintenanceSupervisors as $employee) {
                $employee->user->notify(new ServiceOrderCreated($requestor, $orderNumber));
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function serviceOrdersByUserId($userId)
    {
        try {
            $employee = $this->employeeRepository->employeeByUserId($userId);

            $isDepartmentSupervisor = (($employee['role']->id == 2 || $employee['role']->id == 3) && $employee['department']->id != 2);
            $isMaintenanceDepartmentSupervisor = ($employee['role']->id == 2 && $employee['department']->id == 2);
            $isMaintenanceDepartmentManager = ($employee['role']->id == 3 && $employee['department']->id == 2);
            $isMaintenanceTechnician = ($employee['role']->id == 4 && $employee['department']->id == 2);

            $orders = [];
            if ($isDepartmentSupervisor) {
                $orders = $this->departmentSupervisorOrders($userId);
            } else if ($isMaintenanceDepartmentSupervisor || $isMaintenanceDepartmentManager) {
                $orders = $this->maintenanceSupervisorOrders($isMaintenanceDepartmentManager);
            } elseif ($isMaintenanceTechnician) {
                $orders = $this->maintenanceTechnicianOrders();
            }

            return $orders;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    private function departmentSupervisorOrders($userId)
    {
        try {
            $orders = ['user_role' => 'departmentSupervisor', 'data' => []];

            $data = DB::table('orders')
                ->leftJoin('users', 'orders.technician', '=', 'users.id')
                ->leftJoin('employees', 'users.id', '=', 'employees.user_id')
                ->where('requestor', $userId)
                ->select(
                    'orders.id',
                    'number as order_number',
                    DB::raw('DATE_FORMAT(orders.created_at, "%d/%c/%Y %r") created_at'),
                    DB::raw('UCASE(status) as status'),
                    DB::raw('(CASE WHEN orders.technician is null THEN "Sin asignar" ELSE CONCAT(employees.names, " ", employees.last_names) END) technician')
                )
                ->get();

            $orders['data'] = $data;

            return $orders;
        } catch (\Throwable $th) {
            //throw $th;
            var_dump($th);
        }
    }

    public function serviceOrderByNumber($orderNumber)
    {
        try {
            $detail = DB::table('orders')
                ->join('users', 'orders.requestor', '=', 'users.id')
                ->join('employees as e', 'users.id', '=', 'e.user_id')
                ->join('departments as d', 'e.department_id', '=', 'd.id')
                ->select(
                    'orders.id',
                    DB::raw('concat(e.names," ",e.last_names) requestor'),
                    DB::raw('DATE_FORMAT(orders.created_at, "%d/%c/%Y %r") created_at'),
                    'orders.issue',
                    'orders.number',
                    DB::raw('orders.assignation_date'),
                    'orders.status',
                    'orders.observations',
                    'orders.technician',
                    'orders.diagnosis',
                    'orders.start_date',
                    DB::raw('d.name department'),
                )
                ->where('number', $orderNumber)
                ->first();

            if ($detail == null) {
                throw new Exception('No existe una orden de servicio con este número.', 1);
            }

            $items = Order::where('number', $orderNumber)
                ->first()
                ->items;

            $order = (object)['detail' => $detail, 'items' => $items];

            return $order;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function assignTechnician($orderNumber, $technicianId)
    {

        try {
            $order = Order::where('number', $orderNumber)
                ->first();
            if ($order == null) {
                return new Exception('No se encontró la orden número ' . $orderNumber);
            }

            $technicianUser = User::find($technicianId);

            if ($technicianUser == null) throw new Exception('El técnico indicado es incorrecto.');

            $order->technician = $technicianId;
            $order->assignation_date = now();
            $order->status = 'tecnico asignado';

            $order->save();

            //Notificar al técnico asignado
            $technicianUser->notify(new TechnicianAssigned($orderNumber));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function disapprove($orderNumber, $observations)
    {
        try {
            $order = Order::where('number', $orderNumber)
                ->first();

            if ($order == null) {
                return new Exception('No se encontró la orden número ' . $orderNumber);
            }

            $order->observations = $observations;
            $order->status = 'desaprobado';
            $order->save();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function maintenanceSupervisorOrders($isManager = false)
    {
        $userRole = (!$isManager) ? 'maintenanceSupervisor' : 'maintenanceManager';
        $orders = ['user_role' => $userRole, 'data' => []];

        $data = DB::table('orders')
            ->join('users', 'orders.requestor', '=', 'users.id')
            ->join('employees as e', 'users.id', '=', 'e.user_id')
            ->leftJoin('order_items as orderItems', 'orders.id', '=', 'orderItems.service_order_id')
            ->leftJoin('users as u2', 'orders.technician', '=', 'u2.id')
            ->leftjoin('employees as e2', 'u2.id', '=', 'e2.user_id')
            ->select(
                'orders.id',
                DB::raw('concat(e.names," ",e.last_names) requestor'),
                DB::raw('DATE_FORMAT(orders.created_at, "%d/%c/%Y %r") created_at'),
                'orders.issue',
                'orders.number as order_number',
                'orders.number as order_number',
                DB::raw('CASE WHEN orderItems.service_order_id IS NULL THEN false ELSE true END items_requested'),
                DB::raw('concat(e2.names," ",e2.last_names) technician'),
                'orders.status',
                DB::raw('orderItems.status order_items_status')
            )
            ->whereNull('end_date')
            ->get();

        $orders['data'] = $data;

        return $orders;
    }

    public function storeItemsOrder($orderNumber, $items)
    {
        try {
            if ($items == null) {
                throw new NoServiceOrderItemsException('No se especificaron los materiales requeridos para esta orden de servicio.');
            }

            //Encontramos la orden
            $order = Order::where('number', $orderNumber)
                ->first();

            if ($order == null) {
                return new Exception('La orden a la cual intenta agregar materiales no existe.');
            }

            $orderItem = $order?->orderItem;

            $requestor = $this->employeeRepository
                ->employeeByUserId(auth()->id());

            if (!$orderItem) {
                $orderItem = new OrderItem([
                    'service_order_id' => $order->id,
                    'requestor' => $requestor['id'],
                    'status' => 'en espera de entrega'
                ]);
                $orderItem->save();
            }

            $this->deleteItemFromServiceOrder($orderItem->orderItemDetail);

            foreach ($items as $item) {
                $detail = new OrderItemsDetail();
                $detail->orderItem()->associate($orderItem);
                $detail->quantity = $item['quantity'];
                $detail->item_id = $item['id'];

                $detail->save();
            }

            $order->status = "en espera de materiales";
            $order->save();

            //Notificación al gerente de mantenimiento
            $maintenanceManager = Employee::where('department_id', 2)
                ->where('role_id', 3)
                ->first()
                ->user;
            $maintenanceSupervisorName = $requestor['names'] . ' ' . $requestor['last_names'];
            $maintenanceManager
                ->notify(new ServiceOrderItemRequest($maintenanceSupervisorName, $orderNumber));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    private function deleteItemFromServiceOrder($items)
    {
        foreach ($items as $item) {
            $item->delete();
        }
    }

    public function technicianReport($orderNumber, $technicianReport, $startOrder = false)
    {

        try {
            $order = Order::where('number', $orderNumber)
                ->first();

            $order->diagnosis = $technicianReport;

            if ($startOrder) {
                $order->start_date = now();
            }

            $order->save();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function startOrder($serviceOrderNumber)
    {
        $order = Order::where('number', $serviceOrderNumber)
            ->first();
        $order->start_date = now();
        $order->status = 'orden iniciada';
        $order->save();
    }

    public function finishOrder($serviceOrderNumber)
    {
        $order = Order::where('number', $serviceOrderNumber)
            ->first();
        $order->status = 'orden finalizada';
        $order->end_date = now();
        $order->save();
    }

    public function orderItems($serviceOrderNumber)
    {

        $orderDetail =  $this->serviceOrderByNumber($serviceOrderNumber);

        $items = Order::where('number', $serviceOrderNumber)
            ->first()
            ->items;

        $order = ['detail' => $orderDetail, 'items' => $items];

        return $order;
    }

    public function approveServiceOrderItemRequest($serviceOrderNumber, $approved)
    {
        $orderItemsRequest = Order::where('number', $serviceOrderNumber)
            ->first()
            ->orderItem;

        $orderItemsRequest->status = ($approved)
            ? 'aprobado por gerente de mantenimiento'
            : 'desaprobado por gerente de mantenimiento';
        $orderItemsRequest->save();

        $supervisorsWharehouse = Employee::whereIn('role_id', [2, 3])
            ->where('department_id', 3)
            ->get();

        $users = [];
        foreach ($supervisorsWharehouse as $employee) {
            array_push($users, $employee->user);
        }

        Notification::send($users, new ServiceOrderItemsRequestApproved($serviceOrderNumber));
    }

    public function maintenanceTechnicianOrders()
    {

        $orders = ['user_role' => 'maintenanceTechnician', 'data' => []];

        $data = DB::table('orders')
            ->join('users', 'orders.requestor', '=', 'users.id')
            ->join('employees as e', 'users.id', '=', 'e.user_id')
            ->select(
                'orders.id',
                DB::raw('concat(e.names," ",e.last_names) requestor'),
                DB::raw('DATE_FORMAT(orders.created_at, "%d/%c/%Y %r") created_at'),
                'orders.issue',
                'orders.number as order_number',
            )
            ->whereNull('end_date')
            ->where('technician', auth()->id())
            ->get();


        $orders['data'] = $data;

        return $orders;
    }

    public function ordersWithRequestedItems()
    {
        $orders = Order::whereNull('end_date')
            ->orderItem
            ->get();

        echo json_encode($orders);
    }

    public function pendings()
    {

        try {
            $userId = auth()->id();
            $employee = $this->employeeRepository->employeeByUserId($userId);

            if ($employee == null) {
                throw new NotFoundModelException('No se encontró el empleado con el usuario número ' . $userId);
            }

            $orders = [];
            if (($employee['roleId'] == 2 || $employee['roleId'] == 3)
                && $employee['department']->id != 2
            ) {
                $orders = $this->departmentSupervisorPendings($userId);
            } else if (($employee['roleId'] == 2 || $employee['roleId'] == 3)
                && $employee['department']->id == 2
            ) {
                $orders = $this->maintenanceSupervisorsPendingOrders();
            }

            return $orders;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    private function departmentSupervisorPendings($userId)
    {
        $orders = DB::table('orders')
            ->leftJoin('users', 'orders.technician', '=', 'users.id')
            ->leftJoin('employees', 'users.id', '=', 'employees.user_id')
            ->where('requestor', $userId)
            ->where('status', '!=', 'desaprobado')
            ->where('status', '!=', 'orden finalizada')
            ->select(
                'number as number',
                DB::raw('DATE_FORMAT(orders.created_at, "%d/%c/%Y %r") created_at'),
                DB::raw('UCASE(status) as status'),
                DB::raw('(CASE WHEN orders.technician is null THEN "Sin asignar" ELSE CONCAT(employees.names, " ", employees.last_names) END) technician')
            )
            ->take(5)
            ->get();

        return $orders;
    }

    private function maintenanceSupervisorsPendingOrders()
    {
        $orders = DB::table('orders')
            ->leftJoin('users', 'orders.technician', '=', 'users.id')
            ->leftJoin('employees', 'users.id', '=', 'employees.user_id')
            ->whereNull('technician')
            ->orWhereNull('end_date')
            ->select(
                'number as number',
                DB::raw('DATE_FORMAT(orders.created_at, "%d/%c/%Y %r") created_at'),
                DB::raw('UCASE(status) as status'),
                DB::raw('(CASE WHEN orders.technician is null THEN "Sin asignar" ELSE CONCAT(employees.names, " ", employees.last_names) END) technician')
            )
            ->take(5)
            ->get();

        return $orders;
    }

    public function approved()
    {

        try {
            $userId = auth()->id();
            $employee = $this->employeeRepository->employeeByUserId($userId);

            if ($employee == null) {
                throw new NotFoundModelException('No se encontró el empleado con el usuario número ' . $userId);
            }

            $orders = [];
            if (($employee['roleId'] == 2 || $employee['roleId'] == 3)
                && $employee['department']->id != 2
            ) {
                $orders = $this->departmentSupervisorApproveds($userId);
            } else if (($employee['roleId'] == 2 || $employee['roleId'] == 3)
                && $employee['department']->id == 2
            ) {
                $orders = $this->maintenanceSupervisorApproveds();
            }

            return $orders;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    private function departmentSupervisorApproveds($userId)
    {
        $orders = DB::table('orders')
            ->leftJoin('users', 'orders.technician', '=', 'users.id')
            ->leftJoin('employees', 'users.id', '=', 'employees.user_id')
            ->where('requestor', $userId)
            ->where('status', '!=', 'desaprobado')
            ->select(
                'number as number',
                DB::raw('DATE_FORMAT(orders.created_at, "%d/%c/%Y %r") created_at'),
                DB::raw('DATE_FORMAT(orders.start_date, "%d/%c/%Y %r") start_date'),
                DB::raw('DATE_FORMAT(orders.end_date, "%d/%c/%Y %r") end_date'),
                DB::raw('UCASE(status) as status'),
                DB::raw('(CASE WHEN orders.technician is null THEN "Sin asignar" ELSE CONCAT(employees.names, " ", employees.last_names) END) technician'),
            )
            ->take(5)
            ->get();

        return $orders;
    }

    private function maintenanceSupervisorApproveds()
    {
        $orders = DB::table('orders')
            ->leftJoin('users', 'orders.technician', '=', 'users.id')
            ->leftJoin('employees', 'users.id', '=', 'employees.user_id')
            ->whereNotNull('technician')
            ->select(
                'number as number',
                DB::raw('DATE_FORMAT(orders.created_at, "%d/%c/%Y %r") created_at'),
                DB::raw('DATE_FORMAT(orders.start_date, "%d/%c/%Y %r") start_date'),
                DB::raw('DATE_FORMAT(orders.end_date, "%d/%c/%Y %r") end_date'),
                DB::raw('UCASE(status) as status'),
                DB::raw('(CASE WHEN orders.technician is null THEN "Sin asignar" ELSE CONCAT(employees.names, " ", employees.last_names) END) technician'),
            )
            ->take(5)
            ->get();

        return $orders;
    }
}
