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

    public function serviceOrderItems($serviceOrderNumber){        
        $serviceOrder = Order::where('number', $serviceOrderNumber)->first();

        $details = $serviceOrder
            ?->orderItem
            ?->orderItemDetail;        
        
        $items = ['data' => []];       
        if ($details == null) { return $items; }
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
}
