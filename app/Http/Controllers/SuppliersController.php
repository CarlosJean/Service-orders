<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SuppliersRequest;
use App\Repositories\SuppliersRepository;

class SuppliersController extends Controller
{
    public function index(){
        return view('shopping.suppliers');
    }

    protected $SuppliersRepository;

    public function __construct(
        SuppliersRepository $SuppliersRepository,
    ) 
    
    {
        $this->SuppliersRepository = $SuppliersRepository;
    }

    public function getSuppliers() {
        return $this->SuppliersRepository->suppliers();
    }
    
    
    public function store (SuppliersRequest $request){    
        try {            
            $tipoidentificacion = $request->input('tipoidentificacion');
            $nombre = $request->input('nombre');
            $rnc = $request->input('rnc');
            $direccion = $request->input('direccion');
            $municipio = $request->input('municipio');
            $correo = $request->input('correo');
            $celular = $request->input('celular');



            $this->SuppliersRepository->create($tipoidentificacion, $nombre, $rnc, $direccion, $municipio, $correo, $celular);
            

            return redirect('suppliers');
            
        } catch (\Throwable $th) {
            var_dump($th);
            //throw $th;
        }    
    }
      
    public function update ($id){    
        try {            

            $this->SuppliersRepository->update($id);
           
            return redirect('suppliers');


        } catch (\Throwable $th) {          
            var_dump($th);
            //throw $th;
        }    
    } 
    
    
  
}
