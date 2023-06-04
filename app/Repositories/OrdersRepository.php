<?php

namespace App\Repositories;

use App\Models\Item;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemsDetail;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;

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

            $order = new Order([
                'requestor' => auth()->id(),
                'number' => $orderNumber,
                'issue' => $issue,
                'status' => 'pendiente de asignar tecnico'
            ]);

            $order->save();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function serviceOrdersByUserId($userId)
    {
        try {
            $employee = $this->employeeRepository->employeeByUserId($userId);

            $isDepartmentSupervisor = ($employee['role']->id == 2 && $employee['department']->id != 2);
            $isMaintenanceDepartmentSupervisor = ($employee['role']->id == 2 && $employee['department']->id == 2);

            if ($isDepartmentSupervisor) {
                $orders = $this->departmentSupervisorOrders($userId);
            } else if ($isMaintenanceDepartmentSupervisor) {
                $orders = $this->maintenanceSupervisorOrders();
            }

            return $orders;
        } catch (\Throwable $th) {
            //throw $th;
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
            $order = DB::table('orders')
                ->join('users', 'orders.requestor', '=', 'users.id')
                ->join('employees as e', 'users.id', '=', 'e.user_id')
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
                )
                ->where('number', $orderNumber)
                ->first();

            if ($order == null) {
                throw new Exception('No existe una orden de servicio con este número.', 1);
            }

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
            
            $requestor = $this->employeeRepository->employeeByUserId(auth()->id())['id'];

            $orderItem = new OrderItem([
                'service_order_id' => $order->id,
                'requestor' => $requestor,
                'status' => 'en espera de entrega'
            ]);
            $orderItem->save();
            
            foreach($items as $item){
                $detail = new OrderItemsDetail();
                $detail->orderItem()->associate($orderItem);
                $detail->quantity = $item['quantity'];
                $detail->item_id = $item['id'];

                $detail->save();
            }         
                    
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /*
        *Registra materiales necesarios de una orden de servicio.
        *@param $quote
        *@param $items
    */    
    public function storeItemsToItemsOrder($quote, $items){        
        
        $orderItem = $quote
            ->orderItem;
        
        foreach ($items as $item) {

            echo $item;
            //$item = Item::find($item);
            //$orderItem->orderItemDetail->save($item);
        }        

        echo json_encode($orderItem);
    }
}
