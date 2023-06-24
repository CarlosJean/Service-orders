<?php

namespace App\Repositories;

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
            $isMaintenanceDepartmentSupervisor = (($employee['role']->id == 2 || $employee['role']->id == 3) && $employee['department']->id == 2);
            $isMaintenanceTechnician = ($employee['role']->id == 4 && $employee['department']->id == 2);

            $orders = [];
            if ($isDepartmentSupervisor) {
                $orders = $this->departmentSupervisorOrders($userId);
            } else if ($isMaintenanceDepartmentSupervisor) {
                $orders = $this->maintenanceSupervisorOrders();
            }elseif ($isMaintenanceTechnician) {
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
                ->where('status', '!=', 'finalizada')
                ->select(
                    'orders.id',
                    'number as order_number',
                    DB::raw('DATE_FORMAT(orders.created_at, "%d/%c/%Y %r") created_at'),
                    DB::raw('UCASE(status) as status'),
                    DB::raw('(CASE WHEN orders.technician is null THEN "Sin asignar" ELSE employees.names+" "+employees.last_names END) technician')
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

    public function maintenanceSupervisorOrders()
    {

        $orders = ['user_role' => 'maintenanceSupervisor', 'data' => []];

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
            ->where('status', 'pendiente de asignar tecnico')
            ->where('assignation_date', null)
            ->where('technician', null)
            ->get();


        $orders['data'] = $data;

        return $orders;
    }

    public function storeItemsOrder($orderNumber, $items)
    {
        try {
            //Encontramos la orden
            $order = Order::where('number', $orderNumber)
                ->first();

            if ($order == null) {
                return new Exception('La orden a la cual intenta agregar materiales no existe.');
            }

            $requestor = $this->employeeRepository->employeeByUserId(auth()->id());

            $orderItem = new OrderItem([
                'service_order_id' => $order->id,
                'requestor' => $requestor['id'],
                'status' => 'en espera de entrega'
            ]);
            $orderItem->save();

            foreach ($items as $item) {
                $detail = new OrderItemsDetail();
                $detail->orderItem()->associate($orderItem);
                $detail->quantity = $item['quantity'];
                $detail->item_id = $item['id'];

                $detail->save();
            }

            //Notificación al gerente de mantenimiento
            $maintenanceManager = Employee::where('department_id', 2)
                ->where('role_id', 3)
                ->first()
                ->user;                
            $maintenanceSupervisorName = $requestor['names'].' '.$requestor['last_names'];
            $maintenanceManager
                ->notify(new ServiceOrderItemRequest($maintenanceSupervisorName,$orderNumber));

        } catch (\Throwable $th) {
            throw $th;
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
        $order->save();
    }

    public function finishOrder($serviceOrderNumber)
    {
        $order = Order::where('number', $serviceOrderNumber)
            ->first();
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

        $supervisorsWharehouse = Employee::whereIn('role_id', [2,3])
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
}
