<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    public function create(){
        return view('purchase_orders.create');
    }
    
    public function quoteByNumber(Request $request){
        $quoteNumber = $request->input('quote_number');
        var_dump($quoteNumber);
        return back()
            ->withInput()
            ->with('quoteNumber', $quoteNumber);        
    }
    
    public function store(Request $request){
        //$itemIds = $request->input('');
    }

}
