<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class MaterialsManagementRepository
{
    public function getPendings($isMaintenanceSupervisor = false)
    {
        $orderItems = [];
        if (!$isMaintenanceSupervisor) {
            $orderItems = $this->warehousemanPendings();
        } else {
            $orderItems = $this->maintenanceSupervisorPendings();
        }

        return $orderItems;
    }

    private function warehousemanPendings(){
        $pendings = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.service_order_id')
            ->leftJoin('quotes', 'orders.id', '=', 'quotes.order_id')
            ->leftJoin('users as order_items_users', 'order_items.requestor', '=', 'order_items_users.id')
            ->leftJoin('employees as order_items_employees', 'order_items_users.id', '=', 'order_items_employees.user_id')
            ->leftJoin('users as quote_users', 'quotes.created_by', '=', 'quote_users.id')
            ->leftJoin('employees as quote_employees', 'quote_users.id', '=', 'quote_employees.user_id')
            ->whereNull('order_items.dispatched_by')
            ->select(
                'orders.number as service_order_number',
                DB::raw('DATE_FORMAT(COALESCE(order_items.created_at, quotes.created_at), "%d/%m/%Y %r") as material_request_date'),
                DB::raw('COALESCE(CONCAT(quote_employees.names, " ", quote_employees.last_names), CONCAT(order_items_employees.names, " ", order_items_employees.last_names)) as requestor'),
                DB::raw('"articulos pendientes de despacho" as status'),
            )
            ->get();

        return $pendings;
    }

    private function maintenanceSupervisorPendings(){
        $pendings = DB::table('orders')
            ->leftJoin('order_items', 'orders.id', '=', 'order_items.service_order_id')
            ->leftJoin('quotes', 'orders.id', '=', 'quotes.order_id')
            ->leftJoin('users as order_items_users', 'order_items.requestor', '=', 'order_items_users.id')
            ->leftJoin('employees as order_items_employees', 'order_items_users.id', '=', 'order_items_employees.user_id')
            ->leftJoin('users as quote_users', 'quotes.created_by', '=', 'quote_users.id')
            ->leftJoin('employees as quote_employees', 'quote_users.id', '=', 'quote_employees.user_id')            
            ->select(
                'orders.number as service_order_number',
                DB::raw('DATE_FORMAT(COALESCE(order_items.created_at, quotes.created_at), "%d/%m/%Y %r") as material_request_date'),
                DB::raw('COALESCE(CONCAT(quote_employees.names, " ", quote_employees.last_names), CONCAT(order_items_employees.names, " ", order_items_employees.last_names)) as requestor'),
                DB::raw('CASE WHEN order_items.dispatched_by IS NOT NULL AND quotes.retrieved = 1 THEN "articulos despachados" ELSE "articulos pendientes de despacho" END as status'),
            )
            ->get();

        return $pendings;
    }
}
