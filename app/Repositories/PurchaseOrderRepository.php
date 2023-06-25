<?php

namespace App\Repositories;

use App\Enums\InventoryType;
use App\Models\detail;
use App\Models\Item;
use App\Models\PurchaseOrder;
use App\Models\details;
use App\Models\OrderItem;
use App\Models\OrderItemsDetail;
use App\Models\PurchaseOrderDetail;
use App\Models\Quote;
use Exception;

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
            if ($orderItem == null) {
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

                $purchaseOrderDetail = new PurchaseOrderDetail([
                    'item_id' => $detail['item_id'],
                    'name' => $detail['item'],
                    'quantity' => $detail['quantity'],
                    'price' => $detail['price'],
                    'reference' => $detail['reference'],
                    'total_price' => $detail['quantity'] * $detail['price'],
                    'supplier_id' => $detail['supplier_id'],                    
                ]);

                $purchaseOrderDetail->purchaseOrder()
                    ->associate($purchaseOrder);

                $item->save();
                $purchaseOrderDetail->save();

                //Guardar operacion en histórico
                $item->quantity = $detail['quantity'];
                $this->inventoriesRepository->historical($item, InventoryType::Entry);

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
}
