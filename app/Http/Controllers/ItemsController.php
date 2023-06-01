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

    public function createDeliveryOfMaterials(){

        $this->itemsRepository->itemsByServiceOrderNumber('546646');
        return view('items.delivery');
    }
}
