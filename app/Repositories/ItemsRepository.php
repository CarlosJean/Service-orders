<?php

namespace App\Repositories;

use App\Enums\InventoryType;
use App\Models\Employee;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemsDetail;
use App\Models\PurchaseOrder;
use App\Models\Quote;
use App\Notifications\ServiceOrderItemsDispatch;
use Exception;
use Illuminate\Support\Facades\Notification;

class ItemsRepository
{
    
    protected $inventoriesRepository;
    public function __construct(InventoriesRepository $inventoriesRepository) {
        $this->inventoriesRepository = $inventoriesRepository;
    }

    public function all()
    {
        return Item::get();
    }

    public function available(){
        $items = Item::where('quantity', '>', '0')
            ->get();

        return $items;
    }

    public function item($itemId)
    {
        return Item::find($itemId);
    }

    public function itemsByServiceOrderNumber($serviceOrderNumber)
    {

        try {
            $serviceOrder = Order::where('number', $serviceOrderNumber)
                ->first();

            $orderItems = OrderItem::where('service_order_id', $serviceOrder->id)
                ->first();

            $details = $orderItems->detail;

            $items =  [];
            foreach ($details as $detail) {
                $item = $detail->item;
                //echo json_encode($item);
            }

            $quote = Quote::where('order_id', $serviceOrder->id)
                ->first();

            $purchaseOrder = PurchaseOrder::where('quote_id', $quote->id)
                ->first();

            foreach (/*$quote->purchaseOrderDetail*/$purchaseOrder->detail as $detail) {
                $item = $detail->item;
                echo json_encode($detail);
            }
        } catch (\Throwable $th) {
            var_dump($th);
            //throw $th;
        }
    }

    public function serviceOrderItems($serviceOrderNumber)
    {
        $serviceOrder = Order::where('number', $serviceOrderNumber)->first();

        $details = $serviceOrder
            ?->orderItem
            ?->orderItemDetail
            ->where('dispatched', false);

        $items = ['data' => []];
        if ($details == null) {
            return $items;
        }
        foreach ($details as $detail) {
            array_push($items['data'], [
                'id' => $detail->id,
                'name' => $detail->item->name,
                'reference' => $detail->item->reference,
                'quantity' => $detail->quantity,
            ]);
        }

        return $items;
    }

    public function dispatch($itemsId)
    {

        try {

            $serviceOrderNumber = OrderItemsDetail::find($itemsId[0])
                ->orderItem
                ->serviceOrder
                ->number;

            foreach ($itemsId as $itemId) {
                $orderItem = OrderItemsDetail::find($itemId);
                $orderItem->dispatched = true;
                $orderItem->save();

                $item = Item::find($itemId);
                $item->quantity = $orderItem->quantity;

                $this->inventoriesRepository
                    ->historical($item, InventoryType::Dispatch);
            }

            $maintenanceSupervisorAndManager = Employee::get()
                ->whereIn('role_id', [2,3])
                ->where('department_id', 2);
            
            $users = [];
            foreach ($maintenanceSupervisorAndManager as $employee) {
                array_push($users, $employee->user);
            }
            Notification::send($users, new ServiceOrderItemsDispatch($serviceOrderNumber));

        } catch (\Throwable $th) {
            throw $th;
        }
    }
    
    public function update($id)
    {
        try {

            $model =  Item::find($id);

            if ($model->active == 1)
            $model->active = 0;
                else 
            $model->active = 1;

            $model->save();
        } catch (\Throwable $th) {
                       return redirect()->back() ->with('error',  $th->getMessage());

        }
    }
    
    public function create($description, $nombre,$medida, $precio, $cantidad, $referencia)
    {
        try {

            if ($description == null) {
                throw new Exception('Debe especificar una descripcion.', 1);
            }

            if ($nombre == null) {
                throw new Exception('Debe especificar un nombre.', 1);
            }

            $model = new Item([
                'description' => $description,
                'name' => $nombre,
                'measurement_unit' =>$medida,
                'price' =>$precio, 
                'quantity' =>$cantidad,
                'reference' =>$referencia
            ]);

            $model->save();

        } catch (\Throwable $th) {
                       return redirect()->back() ->with('error',  $th->getMessage());

        }
    }
}
