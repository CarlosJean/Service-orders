<?php

namespace App\Repositories;

use App\Models\Menu;
use App\Models\Role;
use App\Models\Submenu;
use App\Models\Role_Submenu;
use Illuminate\Support\Facades\DB;

use Exception;
use GuzzleHttp\Psr7\Message;

class RolesRepository
{
    public function roles(){
        $roles = Role::select('id','name','description','active')
            ->get()->where('active',1);

        return $roles;
    }


    public function menu(){
        $menu = Menu::select('id','name')
            ->get();

        return $menu;
    }

    public function update($id)
    {
        try {

            $model =  Role::find($id);

            if ($model->active == 1)
            $model->active = 0;
                else 
            $model->active = 1;

            $model->save();
        } catch (\Throwable $th) {
            return redirect()->back() ->with('error',  $th->getMessage());;

        }
    }


    public function createRolSubmenu($submenus, $rolId)
    {
        try {


            foreach ($submenus as &$value) {
                $role_submenu =  Role_Submenu::firstOrNew([
                    'role_id' => $rolId,
                    'submenu_id' => $value
                ]);

                $role_submenu->save();

            }

        } catch (\Throwable $th) {
            return redirect()->back() ->with('error',  $th->getMessage());;

          // echo $th->getMessage();
        }
    }
    
    public function create($description, $nombre)
    {
        try {

            if ($description == null) {
                throw new Exception('Debe especificar una descripcion.', 1);
            }

            if ($nombre == null) {
                throw new Exception('Debe especificar un nombre.', 1);
            }

            $deparment = new Role([
                'description' => $description,
                'name' => $nombre

            ]);

            $deparment->save();

        } catch (\Throwable $th) {
            return redirect()->back() ->with('error',  $th->getMessage());;
        }
    }
    
    public function getRoles(){
        // $roles = Role::select('id','name','description','active')
        //     ->get();

        $roles = DB::table('roles')
          ->leftjoin('role_submenu','role_submenu.role_id','roles.id')
          ->leftjoin('submenus','role_submenu.submenu_id','submenus.id')
          ->select('roles.id','roles.name','roles.description','roles.active',
          DB::raw('GROUP_CONCAT(submenus.name) submenus') )
          ->groupBy('roles.name','roles.description','roles.active','roles.id')
            ->get();

        return $roles;
    }


    public function getSubmenuByMenu($id)
    {

        $Submenu = Submenu::select('id','name')->where('menu_id',$id)
        ->get() ;

    

        if ($id==1)
        $Submenu = Menu::select('id','name')->where('id',$id)
        ->get() ;

  

        return $Submenu;

        // $model = Menu::with('Submenu')
        //     ->where('id', $id)
        //     ->first()
        //     ->submenus;

        // $submenus = [];
        // foreach ($model as $submenus) {
        //     array_push($employees, [
        //         'id' => $submenus->id,
        //         'name' => $submenus->name,
        //     ]);
        // }

        // return $submenus;
    }
    
}
