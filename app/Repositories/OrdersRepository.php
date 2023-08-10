<?php

namespace App\Repositories;

use App\Enums\SystemRoles;
use App\Exceptions\NoServiceOrderItemsException;
use App\Exceptions\NotFoundModelException;
use App\Models\Employee;
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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\Mailer\Exception\TransportException;

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
        return $this->generateOrderNumber();
    }

    private function generateOrderNumber()
    {
        $number = Order::max('number') ?? 0;
        $number = (int)$number + 1;

        return str_pad($number, 6, "0", STR_PAD_LEFT);
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
        } catch (TransportException $ex) {
            Log::warning($ex);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function serviceOrdersByUserId($userId)
    {
        try {
            $employee = $this->employeeRepository->employeeByUserId($userId);

            $isMaintenanceDepartmentSupervisor = ($employee['system_role'] == SystemRoles::MaintenanceSupervisor);
            $isMaintenanceDepartmentManager = ($employee['system_role'] == SystemRoles::MaintenanceManager);
            $isMaintenanceTechnician = ($employee['system_role'] == SystemRoles::MaintenanceTechnician);

            $orders = [];
            if ($isMaintenanceDepartmentSupervisor || $isMaintenanceDepartmentManager) {
                $orders = $this->maintenanceSupervisorOrders($isMaintenanceDepartmentManager);
            } elseif ($isMaintenanceTechnician) {
                $orders = $this->maintenanceTechnicianOrders();
            } else {
                $orders = $this->departmentSupervisorOrders($userId);
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
                ->leftJoin('users as techinican_users', 'orders.technician', 'techinican_users.id')
                ->leftJoin('employees as technicians', 'techinican_users.id', 'technicians.user_id')
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
                    DB::raw('concat(technicians.names," ",technicians.last_names) technician_fullname'),
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

    public function assignTechnician($orderNumber, $technicianId, $assignedBy)
    {

        try {
            $order = Order::where('number', $orderNumber)
                ->first();
            if ($order == null) {
                return new Exception('No se encontró la orden número ' . $orderNumber);
            }

            $technicianUser = Employee::find($technicianId)
                ->user;

            if ($technicianUser == null) throw new Exception('El técnico indicado es incorrecto.');

            $order->technician = $technicianUser->id;
            $order->assignation_date = now();
            $order->status = 'tecnico asignado';
            $order->assigned_by = $assignedBy;

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

            $userId = auth()->id();
            $employee = $this->employeeRepository->employeeByUserId($userId);
            if($employee['system_role'] == SystemRoles::MaintenanceManager){
                $this->approveServiceOrderItemRequest($orderNumber, true);
            }else{
                //Notificación al gerente de mantenimiento
                $maintenanceManager = Employee::where('department_id', 2)
                    ->where('role_id', 3)
                    ->first()
                    ->user;
                $maintenanceSupervisorName = $requestor['names'] . ' ' . $requestor['last_names'];
                $maintenanceManager
                    ->notify(new ServiceOrderItemRequest($maintenanceSupervisorName, $orderNumber));
            }

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
        try {
            $orderDetail =  $this->serviceOrderByNumber($serviceOrderNumber);

            $items = Order::where('number', $serviceOrderNumber)
                ->first()
                ->items;

            $order = ['detail' => $orderDetail, 'items' => $items];

            return $order;
        } catch (\Throwable $th) {
            throw $th;
        }
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
            if ($employee['system_role'] == SystemRoles::DepartmentSupervisor || $employee['system_role'] == SystemRoles::DepartmentManager) {
                $orders = $this->departmentSupervisorPendings($userId);
            } else if ($employee['system_role'] == SystemRoles::MaintenanceSupervisor || $employee['system_role'] == SystemRoles::MaintenanceManager) {
                $orders = $this->maintenanceSupervisorsPendingOrders();
            } else if ($employee['system_role'] == SystemRoles::MaintenanceTechnician) {
                $orders = $this->maintenanceTechnicianPendingOrders($userId);
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
                DB::raw('(CASE WHEN orders.technician is null THEN "Sin asignar" ELSE CONCAT(employees.names, " ", employees.last_names) END) name')
            )
            ->orderBy('orders.created_at')
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
                DB::raw('(CASE WHEN orders.technician is null THEN "Sin asignar" ELSE CONCAT(employees.names, " ", employees.last_names) END) name')
            )
            ->orderBy('orders.created_at')
            ->take(5)
            ->get();

        return $orders;
    }

    private function maintenanceTechnicianPendingOrders($userid)
    {
        $orders = DB::table('orders')
            ->leftJoin('users', 'orders.requestor', '=', 'users.id')
            ->leftJoin('employees', 'users.id', '=', 'employees.user_id')
            ->where('technician', '=', $userid)
            ->WhereNull('end_date')
            ->select(
                'number as number',
                DB::raw('DATE_FORMAT(orders.created_at, "%d/%c/%Y %r") created_at'),
                DB::raw('UCASE(status) as status'),
                DB::raw('CONCAT(employees.names, " ", employees.last_names) name')
            )
            ->orderBy('orders.created_at')
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
            if ($employee['system_role'] == SystemRoles::DepartmentSupervisor || $employee['system_role'] == SystemRoles::DepartmentManager) {
                $orders = $this->departmentSupervisorApproveds($userId);
            } else if ($employee['system_role'] == SystemRoles::MaintenanceSupervisor || $employee['system_role'] == SystemRoles::MaintenanceManager) {
                $orders = $this->maintenanceSupervisorApproveds();
            } else if ($employee['system_role'] == SystemRoles::MaintenanceTechnician) {
                $orders = $this->maintenanceTechnicianApprovedOrders($userId);
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
            ->whereNotNull('technician')
            ->select(
                'number as number',
                DB::raw('DATE_FORMAT(orders.created_at, "%d/%c/%Y %r") created_at'),
                DB::raw('DATE_FORMAT(orders.start_date, "%d/%c/%Y %r") start_date'),
                DB::raw('DATE_FORMAT(orders.end_date, "%d/%c/%Y %r") end_date'),
                DB::raw('UCASE(status) as status'),
                DB::raw('(CASE WHEN orders.technician is null THEN "Sin asignar" ELSE CONCAT(employees.names, " ", employees.last_names) END) name'),
            )
            ->orderBy('orders.created_at')
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
                DB::raw('(CASE WHEN orders.technician is null THEN "Sin asignar" ELSE CONCAT(employees.names, " ", employees.last_names) END) name'),
            )
            ->orderBy('orders.created_at')
            ->take(5)
            ->get();

        return $orders;
    }

    private function maintenanceTechnicianApprovedOrders($userId)
    {
        $orders = DB::table('orders')
            ->leftJoin('users', 'orders.requestor', '=', 'users.id')
            ->leftJoin('employees', 'users.id', '=', 'employees.user_id')
            ->where('technician', $userId)
            ->WhereNotNull('end_date')
            ->select(
                'number as number',
                DB::raw('DATE_FORMAT(orders.created_at, "%d/%c/%Y %r") created_at'),
                DB::raw('DATE_FORMAT(orders.start_date, "%d/%c/%Y %r") start_date'),
                DB::raw('DATE_FORMAT(orders.end_date, "%d/%c/%Y %r") end_date'),
                DB::raw('UCASE(status) as status'),
                DB::raw('CONCAT(employees.names, " ", employees.last_names) name'),
            )
            ->orderBy('orders.created_at')
            ->take(5)
            ->get();

        return $orders;
    }

    public function pendingItemsManagement()
    {
        try {
            $userId = auth()->id();
            $employee = $this->employeeRepository->employeeByUserId($userId);

            if ($employee == null) {
                throw new NotFoundModelException('No se encontró el empleado con el usuario número ' . $userId);
            }

            $orders = [];
            if ($employee['system_role'] == SystemRoles::Warehouseman) {
                $orders = $this->noItemsDispatchedServiceOrders();
            } else if ($employee['system_role'] == SystemRoles::MaintenanceSupervisor || $employee['system_role'] == SystemRoles::MaintenanceManager) {
                $orders = $this->maintenanceSupervisorNoItemsDispatched();
            }

            return $orders;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    private function noItemsDispatchedServiceOrders()
    {
        try {
            $orders = DB::table('order_items')
                ->join('orders', 'order_items.service_order_id', '=', 'orders.id')
                ->leftJoin('users', 'orders.assigned_by', '=', 'users.id')
                ->leftJoin('employees', 'users.id', '=', 'employees.user_id')
                ->whereNull('order_items.dispatched_by')
                ->select(
                    'number as number',
                    DB::raw('DATE_FORMAT(order_items.created_at, "%d/%c/%Y %r") created_at'),
                    DB::raw('UCASE(order_items.status) as status'),
                    DB::raw('CONCAT(employees.names, " ", employees.last_names) name'),
                )
                ->orderBy('order_items.created_at')
                ->take(5)
                ->get();

            return $orders;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    private function maintenanceSupervisorNoItemsDispatched()
    {
        try {
            $orders = DB::table('order_items')
                ->join('orders', 'order_items.service_order_id', '=', 'orders.id')
                ->leftJoin('users', 'order_items.requestor', '=', 'users.id')
                ->leftJoin('employees', 'users.id', '=', 'employees.user_id')
                ->whereNull('order_items.dispatched_by')
                ->select(
                    'number as number',
                    DB::raw('DATE_FORMAT(order_items.created_at, "%d/%c/%Y %r") created_at'),
                    DB::raw('UCASE(order_items.status) as status'),
                    DB::raw('CONCAT(employees.names, " ", employees.last_names) name'),
                )
                ->orderBy('order_items.created_at')
                ->take(5)
                ->get();

            return $orders;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function approvedItemsManagement()
    {
        try {
            $userId = auth()->id();
            $employee = $this->employeeRepository->employeeByUserId($userId);

            if ($employee == null) {
                throw new NotFoundModelException('No se encontró el empleado con el usuario número ' . $userId);
            }

            $orders = [];
            if ($employee['system_role'] == SystemRoles::Warehouseman) {
                $orders = $this->itemsDispatchedServiceOrders();
            } else if ($employee['system_role'] == SystemRoles::MaintenanceSupervisor || $employee['system_role'] == SystemRoles::MaintenanceManager) {
                $orders = $this->maintenanceSupervisorItemsDispatchedServiceOrders();
            }

            return $orders;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    private function itemsDispatchedServiceOrders()
    {
        try {
            $orders = DB::table('order_items')
                ->join('orders', 'order_items.service_order_id', '=', 'orders.id')
                ->leftJoin('users', 'orders.assigned_by', '=', 'users.id')
                ->leftJoin('employees', 'users.id', '=', 'employees.user_id')
                ->whereNotNull('order_items.dispatched_by')
                ->select(
                    'number as number',
                    DB::raw('DATE_FORMAT(order_items.updated_at, "%d/%c/%Y %r") date'),
                    DB::raw('UCASE(order_items.status) as status'),
                    DB::raw('CONCAT(employees.names, " ", employees.last_names) name'),
                )
                ->orderBy('order_items.updated_at')
                ->take(5)
                ->get();

            return $orders;
        } catch (\Throwable $th) {
            var_dump($th);
            //throw $th;
        }
    }
    private function maintenanceSupervisorItemsDispatchedServiceOrders()
    {
        try {
            $orders = DB::table('order_items')
                ->join('orders', 'order_items.service_order_id', '=', 'orders.id')
                ->leftJoin('users', 'order_items.dispatched_by', '=', 'users.id')
                ->leftJoin('employees', 'users.id', '=', 'employees.user_id')
                ->whereNotNull('order_items.dispatched_by')
                ->select(
                    'number as number',
                    DB::raw('DATE_FORMAT(order_items.updated_at, "%d/%c/%Y %r") date'),
                    DB::raw('UCASE(order_items.status) as status'),
                    DB::raw('CONCAT(employees.names, " ", employees.last_names) name'),
                )
                ->orderBy('order_items.updated_at')
                ->take(5)
                ->get();

            return $orders;
        } catch (\Throwable $th) {
            var_dump($th);
            //throw $th;
        }
    }
}
