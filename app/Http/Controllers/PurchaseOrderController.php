<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseOrderRequest;
use App\Repositories\PurchaseOrderRepository;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{

    protected $purchaseOrderRepository;
    public function __construct(PurchaseOrderRepository $purchaseOrderRepository)
    {
        $this->purchaseOrderRepository = $purchaseOrderRepository;
    }

    public function create(){
        $purchaseOrderNumber = $this->purchaseOrderRepository
            ->purchaseOrderNumber();
        return view('purchase_orders.create')->with('purchaseOrderNumber', $purchaseOrderNumber);
    }
    
    public function quoteByNumber(Request $request){
        $quoteNumber = $request->input('quote_number');
        var_dump($quoteNumber);
        return back()
            ->withInput()
            ->with('quoteNumber', $quoteNumber);        
    }
    
    public function store(PurchaseOrderRequest $request){

        try {
            $quoteNumber = $request->input('quote_number');
            $purchaseOrderNumber = $request->input('purchase_order_number');
            $details = $request->input('items');
    
            $this->purchaseOrderRepository
                ->storePurchaseOrder($quoteNumber, $purchaseOrderNumber, $details);

            return view('purchase_orders.created')->with('purchaseOrderNumber', $purchaseOrderNumber);
        } catch (\Throwable $th) {
            var_dump($th);
            //throw $th;
        }
    }

}
