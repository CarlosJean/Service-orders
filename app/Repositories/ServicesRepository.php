<?php

namespace App\Repositories;

use App\Models\Service;
use Exception;

class ServicesRepository{
    public function services($all=false){
        //return Service::get();

    $services = Service::select('name', 'id','description','active') 
    ->get();
    if(!$all) {       
         $services = $services->where('active',1);
    }
      
    return $services;

    }


    public function update($id)
    {
        try {

            $model =  Service::find($id);

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

            $model = new Service([
                'description' => $description,
                'name' => $nombre

            ]);

            $model->save();

        } catch (\Throwable $th) {
                       return redirect()->back() ->with('error',  $th->getMessage());

        }
    }


}
