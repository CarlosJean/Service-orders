<?php

namespace App\Repositories;

use App\Models\Order;
use Exception;
use Illuminate\Support\Facades\DB;

class OrdersRepository
{

    protected $employeeRepository;
    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
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
                'status' => 'pendiente de asignar'
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

            $orders = [];

            $isDepartmentSupervisor = ($employee['role']->id == 2 && $employee['department']->id != 2);
            $isMaintenanceDepartmentSupervisor = ($employee['role']->id == 2 && $employee['department']->id == 2);

            if ($isDepartmentSupervisor) {
                $orders = $this->departmentSupervisorOrders($userId);
            }

            return $orders;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    private function departmentSupervisorOrders($userId)
    {
        try {
            $orders = DB::table('orders')
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

            return $orders;
        } catch (\Throwable $th) {
            //throw $th;
            var_dump($th);
        }
    }
}
