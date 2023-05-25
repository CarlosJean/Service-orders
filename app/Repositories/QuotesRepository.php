<?php

namespace App\Repositories;

use App\Models\Item;
use App\Models\Order;
use App\Models\Quote;
use App\Models\QuoteDetail;
use App\Models\Supplier;
use Exception;
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
            
            //Calculando el costo total de la cotización
            $total = 0;
            foreach ($quoteDetail as $quote) {
                $total += $quote['price'];
            }
            
            //Objeto de cotización
            $newQuote = new Quote([
                'number' => $quoteNumber,
                'created_by' => auth()->id(), 
                'total' => $total
            ]);
            
            $serviceOrder = Order::where('number', $orderNumber)->first();
            if ($serviceOrder != null) {
                $newQuote->order_id = $serviceOrder->id;
            }
            $newQuote->save();
            
            foreach ($quoteDetail as $quote) {      

                if($quote['supplier_id'] == null) {
                    throw new Exception('Debe indicar el suplidor del artículo '.$quote['item'].'.');
                }

                $noSpaceWhere = DB::raw("LOWER(replace(name,' ',''))");                
                $noSpaceItemName = str_replace(' ','',$quote['item']);
                $noSpaceItemName = strtolower($noSpaceItemName);                
                
                $newQuoteDetail = new QuoteDetail([
                    'item' => $quote['item'],
                    'reference' => $quote['reference'],
                    'quantity' => $quote['quantity'],
                    'price' => $quote['price'], 
                    'supplier_id' => $quote['supplier_id'],
                ]);
                
                $itemId = Item::where($noSpaceWhere, $noSpaceItemName)
                    ->first()
                    ?->id;
                    
                if ($itemId != null) {
                    $newQuoteDetail->item_id = $itemId;
                }

                $newQuoteDetail->quote()->associate($newQuote);
                $newQuoteDetail->save();                
            }

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}