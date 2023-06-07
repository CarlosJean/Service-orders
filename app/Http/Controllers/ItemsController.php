<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\ItemsRepository;
use Illuminate\Http\Request;

class ItemsController extends Controller
{
    protected $itemsRepository;
    public function __construct(ItemsRepository $itemsRepository ){
        $this->itemsRepository = $itemsRepository;
    }

    public function getItems(){
        $items = $this->itemsRepository->all();
        return $items;
    }    

    public function createDispatchMaterials(){
        
        return view('items.dispatch');
    }
    
    public function createDeliveryOfMaterials(Request $request){
        $serviceOrderNumber = $request->input('service_order_number');
        $this->itemsRepository->serviceOrderItems($serviceOrderNumber);
        return view('items.delivery');
    }

    public function storeDispatch(Request $request){       
        try {
            $itemsId = $request->input('items');
            $this->itemsRepository->dispatch($itemsId);

            return view('items.dispatched');
        } catch (\Throwable $th) {
            var_dump($th);
            //throw $th;
        } 
    }
}
