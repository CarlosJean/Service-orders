<?php

namespace App\Repositories;

use App\Models\Item;
use App\Models\Order;
use App\Models\Quote;
use App\Models\QuoteDetail;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;

class QuotesRepository
{    
    
    public function quoteNumber(){
        $quoteNumber = $this->newQuoteNumber();        
        return $quoteNumber;
    }    
    
    private function newQuoteNumber(){
        
        $number = rand(111111, 999999);
        $isUsed =  Quote::where('number', $number)->first();
        if ($isUsed) {
            return $this->newQuoteNumber();
        }
        return $number;
    }

    public function storeQuote($quoteNumber, $orderNumber, $quoteDetail){
        try {         
            
            $total = 0;
            foreach ($quoteDetail as $quote) {
                $total += $quote['price'];
            }

            $order = Order::where('number', $orderNumber)->first();

            $newQuote = new Quote([
                'number' => $quoteNumber,
                'created_by' => auth()->id(), 
                'order_id' => $order->id, 
                'total' => $total
            ]);
            $newQuote->save();
            
            foreach ($quoteDetail as $quote) {      

                $noSpaceWhere = DB::raw("replace(name,' ','')");
                $noSpaceItemName = str_replace(' ','',$quote['item']);
                
                $itemId = Item::where($noSpaceWhere, $noSpaceItemName)
                    ->first()
                    ->id;
                
                $newQuoteDetail = new QuoteDetail([
                    'item_id' => $itemId,
                    'item' => $quote['item'],
                    'reference' => $quote['reference'],
                    'quantity' => $quote['quantity'],
                    'price' => $quote['price'], 
                    'supplier_id' => $quote['supplier_id'],
                ]);
                $newQuoteDetail->quote()->associate($newQuote);
                $newQuoteDetail->save();                
            }

        } catch (\Throwable $th) {
            var_dump($th);
            //throw $th;
        }
    }
}