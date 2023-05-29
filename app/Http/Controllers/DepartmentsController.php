<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterDeparmentRequest;
use App\Repositories\DepartmentsRepository;

class DepartmentsController extends Controller
{
    public function index(){
        return view('orders.departments');
    }

    protected $deparmentRepository;

    public function __construct(
        DepartmentsRepository $deparmentRepository,
    ) 
    
    {
        $this->deparmentRepository = $deparmentRepository;
    }
    
    
    public function store (RegisterDeparmentRequest $request){    
        try {            
            $description = $request->input('descripcion');
            $nombre = $request->input('nombre');


            $this->deparmentRepository->create($description, $nombre);
            

            return redirect('departments');
            
        } catch (\Throwable $th) {
            var_dump($th);
            //throw $th;
        }    
    }
      
    public function update ($id){    
        try {            

            $this->deparmentRepository->update($id);
           
            return redirect('departments');


        } catch (\Throwable $th) {          
            var_dump($th);
            //throw $th;
        }    
    } 
    
    
  
}
