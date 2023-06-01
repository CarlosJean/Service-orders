<?php
namespace App\Repositories;

use App\Models\Item;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PurchaseOrder;
use App\Models\Quote;

class ItemsRepository{    

    public function all(){
        return Item::get();
    }

    public function item($itemId){
        return Item::find($itemId);
    }

    public function itemsByServiceOrderNumber($serviceOrderNumber){

        try {
            $serviceOrder = Order::where('number', $serviceOrderNumber)
                ->first();
    
            $orderItems = OrderItem::where('service_order_id', $serviceOrder->id)
                ->first();

            $details = $orderItems->detail;

            $items =  [];
            foreach ($details as $detail) {
                $item = $detail->item;
                echo json_encode($item);
            }

            $quote = Quote::where('order_id', $serviceOrder->id)
                ->first();

            $purchaseOrder = PurchaseOrder::where('qote_id', $quote->id)
                ->first();

            foreach ($quote->purchaseOrderDetail/*$purchaseOrder->detail*/ as $detail) {
                $item = $detail->item;
                echo json_encode($item);
            }
            

        } catch (\Throwable $th) {
            var_dump($th);
            //throw $th;
        }
    }
}
