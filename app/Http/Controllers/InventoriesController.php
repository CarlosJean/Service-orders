<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\InventoriesRepository;
use Illuminate\Http\Request;
use App\Http\Requests\InventoryValueRequest;

class InventoriesController extends Controller
{

    protected $inventoriesRepository;
    public function __construct(InventoriesRepository $inventoriesRepository)
    {
        $this->inventoriesRepository = $inventoriesRepository;
    }

    public function index(Request $request){
        return view('inventory.inventory_value');

    }

    public function getInventory(InventoryValueRequest $request){
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('fromDate');
        return $data = $this->inventoriesRepository->getByDate($fromDate, $toDate);
    }
}
