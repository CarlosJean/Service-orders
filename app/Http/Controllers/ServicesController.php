<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServicesController extends Controller
{

    protected $servicesRepository;
    


    public function index(){
        return view('orders.services');
    }

    public function getServices()
    {
        $employees = $this->employeeRepository
            ->services();

        echo json_encode($employees);
    }


  
}
