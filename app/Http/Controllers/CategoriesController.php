<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterCategoriesRequest;
use App\Repositories\CategoriesRepository;

class CategoriesController extends Controller
{

    protected $CategoriesRepository;

    public function __construct(
        CategoriesRepository $CategoriesRepository,
    ) 
    
    {
        $this->CategoriesRepository = $CategoriesRepository;
    }
    


    public function index(){
        return view('inventory.categories');
    }


    public function store (RegisterCategoriesRequest $request){    
        try {            
            $description = $request->input('descripcion');
            $nombre = $request->input('nombre');


            $this->CategoriesRepository->create($description, $nombre);
            

            return redirect('categories');
            
        } catch (\Throwable $th) {
            var_dump($th);
            //throw $th;
        }    
    }
      
    public function update ($id){    
        try {            

            $this->CategoriesRepository->update($id);
           
            return redirect('categories');


        } catch (\Throwable $th) {          
            var_dump($th);
            //throw $th;
        }    
    } 

    public function getCategories()
    {
        return $this->CategoriesRepository->categories();
    }
  
}
