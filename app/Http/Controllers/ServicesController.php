<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterServicesRequest;
use App\Repositories\ServicesRepository;

class ServicesController extends Controller
{

    protected $servicesRepository;

    public function __construct(
        ServicesRepository $servicesRepository,
    ) 
    
    {
        $this->servicesRepository = $servicesRepository;
    }
    


    public function index(){
        return view('orders.services');
    }


    public function store (RegisterServicesRequest $request){    
        try {            
            $description = $request->input('descripcion');
            $nombre = $request->input('nombre');


            $this->servicesRepository->create($description, $nombre);
            

            return redirect('services');
            
        } catch (\Throwable $th) {
            var_dump($th);
            //throw $th;
        }    
    }
      
    public function update ($id){    
        try {            

            $this->servicesRepository->update($id);
           
            return redirect('services');


        } catch (\Throwable $th) {          
            var_dump($th);
            //throw $th;
        }    
    } 

    // public function getServices()
    // {
    //     $employees = $this->employeeRepository
    //         ->services();

    //     echo json_encode($employees);
    // }


  
}
