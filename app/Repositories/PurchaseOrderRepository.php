<?php

namespace App\Repositories;

use App\Models\detail;
use App\Models\Item;
use App\Models\PurchaseOrder;
use App\Models\details;
use App\Models\PurchaseOrderDetail;
use App\Models\Quote;
use Exception;

class PurchaseOrderRepository
{

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

            foreach ($details as $detail) {

                $item = new Item();
                if ($detail['item_id'] == 'null') {
                    $detail['item_id'] = null;
                    $item = new Item([
                        'name' => $detail['item'],
                        'quantity' => $detail['quantity'],
                        'price' => $detail['price'],
                        'reference' => $detail['reference'],
                        'measurement_unit' => 'unidad'
                    ]);
                } else {
                    $item = Item::find($detail['item_id']);
                    $item->price = $detail['price'];
                    $item->quantity += $detail['quantity'];
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
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
