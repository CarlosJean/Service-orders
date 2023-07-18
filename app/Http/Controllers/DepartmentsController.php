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


    public function getDeparments()
    {
        return   $this->deparmentRepository->departments(true);
    }
    
    public function store (RegisterDeparmentRequest $request){    
        try {            
            $description = $request->input('descripcion');
            $nombre = $request->input('nombre');


            $this->deparmentRepository->create($description, $nombre);
            

           // return redirect('departments');
            
            return back()->with('success',  'Registro creado!');
            
        } catch (\Throwable $th) {
            return back()->with('error',  $th->getMessage());
            //throw $th;
        }    
    }
      
    public function update ($id){    
        try {            

            $this->deparmentRepository->update($id);
           
            //return redirect('departments');

            echo json_encode(['type' => 'success','message' => 'Cambios aplicados correctamente!']);

            
        } catch (\Throwable $th) {
            echo json_encode(['type' => 'error','message' => $th->getMessage()]);
            //throw $th;
        }    
    } 


   

    
    
  
}
