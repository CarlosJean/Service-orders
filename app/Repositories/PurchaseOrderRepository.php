<?php

namespace App\Repositories;

use App\Enums\InventoryType;
use App\Exceptions\NotFoundModelException;
use App\Models\detail;
use App\Models\Item;
use App\Models\PurchaseOrder;
use App\Models\details;
use App\Models\OrderItem;
use App\Models\OrderItemsDetail;
use App\Models\PurchaseOrderDetail;
use App\Models\Quote;
use Exception;
use Illuminate\Support\Facades\DB;

class PurchaseOrderRepository
{

    protected $ordersRepository;
    protected $employeeRepository;
    protected $inventoriesRepository;
    public function __construct(
        OrdersRepository $ordersRepository,
        EmployeeRepository $employeeRepository,
        InventoriesRepository $inventoriesRepository
    ) {
        $this->ordersRepository = $ordersRepository;
        $this->employeeRepository = $employeeRepository;
        $this->inventoriesRepository = $inventoriesRepository;
    }

    public function purchaseOrderNumber()
    {
        $number = rand(111111, 999999);
        $isUsed =  Quote::where('number', $number)->first();
        if ($isUsed) {
            return $this->purchaseOrderNumber();
        }
        return $number;
    }

    public function storePurchaseOrder($quoteNumber, $purchaseOrderNumber, $details)
    {
        try {
            $quote = Quote::where('number', $quoteNumber)?->first();
            if ($quote == null) {
                return new Exception('No se encontró una cotización con el número ' . $quoteNumber);
            }

            $purchaseOrder = new PurchaseOrder([
                'user_id' => auth()->id(),
                'quote_id' => $quote->id,
                'number' => $purchaseOrderNumber,
            ]);
            $purchaseOrder->total = collect($details)->sum('price');
            $purchaseOrder->save();

            $maintenanceSupervisor = $this->employeeRepository
                ?->employeeByRoleAndDepartment(2, 2)
                ?->first()
                ->user_id;

            $orderItem = $quote->orderItem;
            if ($orderItem != null) {
                $orderItem = new OrderItem([
                    'service_order_id' => $quote->order_id,
                    'requestor' => $maintenanceSupervisor,
                    'status' => 'en espera de entrega',
                ]);

                $orderItem->save();
            }

            foreach ($details as $detail) {

                $item = new Item();

                /*
                    Si el item id está nulo quiere decir que el artículo no existe.
                    Se inserta en la base de datos.                
                */
                if ($detail['item_id'] == 'null') {
                    $detail['item_id'] = null;
                    $item = new Item([
                        'name' => $detail['item'],
                        'quantity' => $detail['quantity'],
                        'price' => $detail['price'],
                        'reference' => $detail['reference'],
                        'measurement_unit' => 'unidad',
                        'description' => $detail['reference']
                    ]);
                } else {
                    $item = Item::find($detail['item_id']);
                    $item->price = $detail['price'];
                    $item->quantity += $detail['quantity'];
                    $item->description += $detail['reference'];
                }

                $item->quantity = $detail['quantity'];
                $item->save();

                $purchaseOrderDetail = new PurchaseOrderDetail([
                    'item_id' => $item->id,
                    'name' => $detail['item'],
                    'quantity' => $detail['quantity'],
                    'price' => $detail['price'],
                    'reference' => $detail['reference'],
                    'total_price' => $detail['quantity'] * $detail['price'],
                    'supplier_id' => $detail['supplier_id'],
                ]);

                $purchaseOrderDetail->purchaseOrder()
                    ->associate($purchaseOrder);

                $purchaseOrderDetail->save();

                //Guardar operacion en histórico
                $this->inventoriesRepository->historical($item, InventoryType::Entry);

                $quote->retrieved = true;
                $quote->save();

                //Si la cotización no está asociada a una orden de servicio entonces el programa finaliza
                if ($quote->order == null) return;

                $orderItemDetail = new OrderItemsDetail();
                $orderItemDetail->item()->associate($item);
                $orderItemDetail->orderItem()->associate($orderItem);
                $orderItemDetail->quantity = $detail['quantity'];
                $orderItemDetail->save();

                return $orderItemDetail;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getPurchaseOrder($number)
    {
        $purchaseOrderFound = PurchaseOrder::where('number', $number)->first();

        if (!$purchaseOrderFound) {
            throw new NotFoundModelException('No se encontró la cotización con el número ' . $number . '.');
        }

        $purchaseOrder = [
            'summary' => ['number' => 0, 'user_id' => '', 'date' => ''],
            'detail' => [],
            'totals' => ['quantity' => 0, 'price' => 0]
        ];

        $purchaseOrder['summary'] = DB::table('purchase_orders')
            ->join('users', 'purchase_orders.user_id', 'users.id')
            ->join('employees', 'employees.user_id', 'users.id')
            ->where('purchase_orders.number', $number)
            ->select(
                'purchase_orders.number',
                DB::raw('CONCAT(employees.names, " ", employees.last_names) created_by'),
                DB::raw('DATE_FORMAT(purchase_orders.created_at, "%d/%m/%Y %r") date'),
            )
            ->first();

        $purchaseOrder['detail'] = DB::table('purchase_orders')
            ->join('purchase_order_details', 'purchase_orders.id', '=', 'purchase_order_details.purchase_order_id')
            ->join('items', 'items.id', '=', 'purchase_order_details.item_id')
            ->join('suppliers', 'suppliers.id', '=', 'purchase_order_details.supplier_id')
            ->where('purchase_orders.number', '=', $number)
            ->select(
                'items.name as item',
                DB::raw('CASE WHEN purchase_order_details.reference IS NULL THEN purchase_order_details.reference ELSE "" END  as reference'),
                'purchase_order_details.quantity',
                'purchase_order_details.price',
                'purchase_order_details.total_price',
                'suppliers.name as supplier',
            )
            ->get();

        $purchaseOrder['totals']['quantity'] = $purchaseOrder['detail']->sum('quantity');
        $purchaseOrder['totals']['price'] = $purchaseOrder['detail']->sum('price');

        return $purchaseOrder;
    }

    public function getPurchaseOrders()
    {
        $purchaseOrders = DB::table('purchase_orders')
            ->join('users', 'purchase_orders.user_id', 'users.id')
            ->join('employees', 'employees.user_id', 'users.id')
            ->select(
                DB::raw('DATE_FORMAT(purchase_orders.created_at, "%d/%m/%Y %r") date'),
                DB::raw('CONCAT(employees.names, " ", employees.last_names) created_by'),
                'purchase_orders.number',
                'purchase_orders.total',
            )
            ->get();

        return $purchaseOrders;
    }
}
