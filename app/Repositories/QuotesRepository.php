<?php

namespace App\Repositories;

use App\Models\Quote;
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
}
