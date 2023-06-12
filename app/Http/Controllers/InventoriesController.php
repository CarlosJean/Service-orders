<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\InventoriesRepository;
use Illuminate\Http\Request;

class InventoriesController extends Controller
{

    protected $inventoriesRepository;
    public function __construct(InventoriesRepository $inventoriesRepository)
    {
        $this->inventoriesRepository = $inventoriesRepository;
    }

    public function index(Request $request){
        $fromDate = $request->query('fromDate');
        $toDate = $request->query('toDate');

        $this->inventoriesRepository->getByDate($fromDate, $toDate);
    }
}
