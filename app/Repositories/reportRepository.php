<?php

namespace App\Repositories;

use App\Enums\InventoryType;
use App\Enums\SystemRoles;
use App\Models\Employee;
use App\Models\Inventory;
use App\Models\Item;
use Exception;
use Illuminate\Support\Facades\DB;

class reportRepository
{

    protected $employeeRepository;

    public function __construct(
        EmployeeRepository $employeeRepository,

    ) {
        $this->employeeRepository = $employeeRepository;
    }

    public function getReportByRole()
    {
        $userId = auth()->id();
        $employee = $this->employeeRepository->employeeByUserId($userId);

        $roleId = $employee['role']->id;
        $departmentId = $employee['department']->id;

        $data = null;

        $data2 = null;

        $systemRole = Employee::find($employee['id'])->getSystemRoleAttribute();

        //if ($departmentId == 2 && ($roleId == 2 || $roleId == 3)) {
        if ($systemRole == SystemRoles::MaintenanceManager || $systemRole == SystemRoles::MaintenanceSupervisor) {
            //  supervisor y gerente de mantenimientos;
            $data = [
                'id' => "Reporte costo por servicios",
                'name' => "Reporte costo por servicios"
            ];
            $data2 = [
                'id' => "Reporte servicios",
                'name' => "Reporte servicios",
            ];
        } else if ($systemRole == SystemRoles::Warehouseman) {
            // supervisor y operador de alamacen;
            $data = [
                'id' => "Reporte de compras",
                'name' => "Reporte de compras"
            ];
        } else if ($systemRole == SystemRoles::SystemAdmin) {
            // administrador de sistema;
            $data = [
                'id' => "Reporte de usuarios registrados",
                'name' => "Reporte de usuarios registrados"
            ];
        }


        return  json_encode([$data,  $data2]);;
    }

    public function getReportByDate($fromDate, $toDate, $type)
    {

        $from = date($fromDate . ' 00:00:00');
        $to = date($toDate . ' 23:59:59');
        $data = "";

        if ($type == "Reporte de compras") {
            $from = date($fromDate . ' 00:00:00');
            $to = date($toDate . ' 23:59:59');

            $data = DB::table('purchase_orders')
                ->whereBetween('purchase_orders.created_at',  [$from, $to])
                ->leftjoin('purchase_order_details', 'purchase_order_details.purchase_order_id', '=', 'purchase_orders.id')
                ->leftjoin('items', 'purchase_order_details.item_id', '=', 'items.id')
                ->select(
                    'purchase_orders.id',
                    'purchase_orders.created_at',
                    'items.name',
                    'items.reference',
                    'purchase_order_details.quantity',
                    'purchase_order_details.price',
                    'purchase_order_details.total_price'
                )
                //->groupBy('items.id', 'items.name', 'items.reference', 'inventories.created_at')
                ->get();
        }


        if ($type == "Reporte de usuarios registrados") {
            $from = date($fromDate . ' 00:00:00');
            $to = date($toDate . ' 23:59:59');

            $data = DB::table('users')
                ->whereBetween('users.created_at',  [$from, $to])
                //->leftjoin('purchase_order_details', 'purchase_order_details.purchase_order_id', '=', 'purchase_orders.id')
                ->select(
                    'users.id',
                    'users.created_at',
                    'users.name',
                    'users.email'
                )
                //->groupBy('items.id', 'items.name', 'items.reference', 'inventories.created_at')
                ->get();
        }


        if ($type == "Reporte servicios") {
            $from = date($fromDate . ' 00:00:00');
            $to = date($toDate . ' 23:59:59');

            $data = DB::table('orders')
                ->whereBetween('orders.created_at',  [$from, $to])
                ->leftjoin('users', 'orders.requestor', '=', 'users.id')
                ->leftjoin('employees', 'users.id', '=', 'employees.user_id')
                ->leftjoin('users as technician_users', 'orders.technician', '=', 'technician_users.id')
                ->leftjoin('employees as technician', 'technician_users.id', '=', 'technician.user_id')
                ->leftjoin('users as assigned_by_users', 'orders.assigned_by', '=', 'assigned_by_users.id')
                ->leftjoin('employees as assigned_by_employees', 'assigned_by_users.id', '=', 'assigned_by_employees.user_id')
                ->leftjoin('order_items', 'orders.id', '=', 'order_items.service_order_id')
                ->leftjoin('order_items_details', 'order_items_details.item_id', '=', 'order_items.id')
                ->select(
                    'orders.number',
                    DB::raw('CONCAT(employees.names, " ",employees.last_names) as requestor'),
                    'orders.assignation_date',
                    DB::raw('CONCAT(assigned_by_employees.names, " ",assigned_by_employees.last_names) as assigned_by'),
                    DB::raw('CONCAT(technician.names, " ",technician.last_names) as technician'),
                    'orders.issue',
                    'orders.diagnosis',
                    'orders.start_date',
                    'orders.end_date',
                    'orders.observations',
                    'orders.status'
                )
                //->groupBy('items.id', 'items.name', 'items.reference', 'inventories.created_at')
                ->get();
        }

        if ($type == "Reporte costo por servicios") {
            $from = date($fromDate . ' 00:00:00');
            $to = date($toDate . ' 23:59:59');

            $data = DB::table('orders')
                ->whereBetween('orders.created_at',  [$from, $to])

                ->leftjoin('employees', 'orders.requestor', '=', 'employees.id')
                ->leftjoin('order_items', 'orders.id', '=', 'order_items.service_order_id')
                ->leftjoin('order_items_details', 'order_items_details.order_item_id', '=', 'orders.id')
                ->leftjoin('items', 'items.id', '=', 'order_items_details.item_id')
                ->leftJoin('inventories', function ($join)
                use ($from) {
                    $join->on('inventories.item_id', '=', 'order_items_details.item_id');
                })
                ->select(
                    'orders.number',
                    DB::raw('count( order_items_details.item_id)  as cantidad_articulos'),
                    DB::raw('sum(round(IFNULL(IFNULL(inventories.price,items.price),0),2)) as total_cost'),
                )
                ->groupBy('orders.number')
                ->get();
        }

        return $data;
    }
}
