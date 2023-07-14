<?php

namespace App\Repositories;

use App\Enums\InventoryType;
use App\Models\Inventory;
use App\Models\Item;
use Exception;
use Illuminate\Support\Facades\DB;

class reportRepository
{

    protected $employeeRepository;

    public function __construct(
        EmployeeRepository $employeeRepository,

    ) 
    
    {
        $this->employeeRepository = $employeeRepository;
   
    }

    public function getReportByRole()
    {
        $userId = auth()->id();
        $employee = $this->employeeRepository->employeeByUserId($userId);
            $roleId = $employee['role']->id;
            $departmentId = $employee['department']->id;

            $data=null;

            $data2=null;

            if ($departmentId == 2 && ($roleId == 2 || $roleId == 3)) {
              //  supervisor y gerente de mantenimientos;
              $data=[
                'id' => "Reporte costo por servicios",
                'name' => "Reporte costo por servicios"
              ];
              $data2=[
                'id' => "Reporte servicios",
                'name' => "Reporte servicios",
              ];

            } else if ($departmentId == 3 && ($roleId == 2 || $roleId == 5)) {
              // supervisor y operador de alamacen;
              $data=[
                'id' => "Reporte de compras",
                'name' => "Reporte de compras"
              ];
            } else if ($roleId == 1) {
                // administrador de sistema;
                $data=[
                  'id' => "Reporte de usuarios registrados",
                  'name' => "Reporte de usuarios registrados"
                ];
              }


            return  json_encode([ $data,  $data2 ]);;
    }

    public function getReportByDate($fromDate, $toDate, $type)
    {

        $from = date($fromDate);
        $to = date($toDate);
        $data="";

        if ($type == "Reporte de compras")
    {
   
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

    
    if ($type == "Reporte de usuarios registrados")
    {
   
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

      
    if ($type == "Reporte servicios")
    {
   
        $data = DB::table('orders')
            ->whereBetween('orders.created_at',  [$from, $to])
            ->leftjoin('employees', 'orders.requestor', '=', 'employees.id')
            ->leftjoin('order_items', 'orders.id', '=', 'order_items.service_order_id')
            ->leftjoin('order_items_details', 'order_items_details.item_id', '=', 'order_items.id')
            ->select(
                'orders.number',
                'employees.names as requestor',
                'orders.assignation_date',
                'orders.assigned_by',
                'orders.technician',
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

    if ($type == "Reporte costo por servicios")
    {
   
        $data = DB::table('orders')
            ->whereBetween('orders.created_at',  [$from, $to])
          
            ->leftjoin('employees', 'orders.requestor', '=', 'employees.id')
            ->leftjoin('order_items', 'orders.id', '=', 'order_items.service_order_id')
            ->leftjoin('order_items_details', 'order_items_details.order_item_id', '=', 'orders.id')
            ->leftjoin('items', 'items.id', '=', 'order_items_details.item_id')
            ->leftJoin('inventories', function($join)
            use($from) {
            $join->on('inventories.item_id', '=', 'order_items_details.item_id');
        }) 
            ->select(
                'orders.number' ,
                DB::raw('count( order_items_details.item_id)  as cantidad_articulos') ,          
                DB::raw('sum(round(IFNULL(IFNULL(inventories.price,items.price),0),2)) as total_cost') ,          
            ) 
            ->groupBy('orders.number')
            ->get();                 
    }

        return $data;
    }
}
