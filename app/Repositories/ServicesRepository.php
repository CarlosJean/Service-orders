<?php

namespace App\Repositories;

use App\Models\Service;
use Exception;

class ServicesRepository{
    public function services(){
        //return Service::get();

        $services = Service::select('name', 'id','description') ->where('active', 1)
        ->get();
        
    return $services;

    }


    public function update($id)
    {
        try {

            $model =  Service::find($id);

            $model->active = 0;

            $model->save();
        } catch (\Throwable $th) {
            throw $th;
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
            throw $th;
        }
    }


}
