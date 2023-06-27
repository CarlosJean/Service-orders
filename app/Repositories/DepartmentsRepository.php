<?php

namespace App\Repositories;

use App\Models\Department;
use Exception;

class DepartmentsRepository
{
    public function departments($all=false)
    {

        $departments = Department::select('name', 'id','description','active') 
        ->get();
        if(!$all) {       
             $departments = $departments->where('active',1);
        }
          
        return $departments;
    }

    // public function getDepartments()
    // {
    //     $departments = Department::select('name', 'id','description','active') 
    //         ->get();
            
    //     return $departments;
    // }


    
    public function update($id)
    {
        try {

            $model =  Department::find($id);

            if ($model->active == 1)
            $model->active = 0;
                else 
            $model->active = 1;

            $model->save();
        } catch (\Throwable $th) {
                       return redirect()->back() ->with('error',  $th->getMessage());

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

            $deparment = new Department([
                'description' => $description,
                'name' => $nombre

            ]);

            $deparment->save();

        } catch (\Throwable $th) {
                       return redirect()->back() ->with('error',  $th->getMessage());

        }
    }
}
