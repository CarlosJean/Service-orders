<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRoleRequest;
use App\Repositories\RolesRepository;

class RoleController extends Controller
{

    protected $RolesRepository;

    public function __construct(
        RolesRepository $RolesRepository,
    ) 
    
    {
        $this->RolesRepository = $RolesRepository;
    }
    


    public function index(){
        return view('employees.roles');
    }

    

    public function storeRolSubmenu (RegisterRoleRequest $request){    
        try {            
            $submenus = $request->input('slcSubmenu');
            $rolId = $request->input('rolId');


            $this->RolesRepository->createRolSubmenu($submenus, $rolId);
            

           return redirect('roles');
            
        } catch (\Throwable $th) {
            var_dump($th);
            //throw $th;
        }    
    }


    public function store (RegisterRoleRequest $request){    
        try {            
            $description = $request->input('descripcion');
            $nombre = $request->input('nombre');


            $this->RolesRepository->create($description, $nombre);
            

            return redirect('roles');
            
        } catch (\Throwable $th) {
            var_dump($th);
            //throw $th;
        }    
    }
      
    public function update ($id){    
        try {            

            $this->RolesRepository->update($id);
           
            return redirect('roles');


        } catch (\Throwable $th) {          
            return redirect()->back() ->with('error',  $th->getMessage());;
            //throw $th;
        }    
    } 

    public function getRoles()
    {
        try {       

        return $this->RolesRepository->getRoles();

    } catch (\Throwable $th) {          
       // return redirect()->back() ->with('error',  $th->getMessage());;
        throw $th;
    }    
    }

    public function getMenus()
    {
        return $this->RolesRepository->menu();
    }

    public function getSubmenuByMenu($Id)
    {
        return $this->RolesRepository->getSubmenuByMenu($Id);
    }

  
}
