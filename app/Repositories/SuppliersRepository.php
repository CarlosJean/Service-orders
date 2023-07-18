<?php

namespace App\Repositories;

use App\Models\Suppliers;
use Exception;

class SuppliersRepository
{
    public function suppliers($all=false)
    {
        $suppliers = Suppliers::select('id','name', 'address','city','email','cellphone','ident','identType','active')
            ->get();

            if(!$all) {       
                $suppliers = $suppliers ->where('active',1);
            }
            
        return $suppliers;
    }

    
    public function update($id)
    {
        try {

            $model =  Suppliers::find($id);

            if ($model->active == 1)
            $model->active = 0;
                else 
            $model->active = 1;

            $model->save();
        } catch (\Throwable $th) {
                       return redirect()->back() ->with('error',  $th->getMessage());

        }
    }
    
    public function create($tipoidentificacion, $nombre, $rnc, $direccion, $municipio, $correo, $celular)
    {
        try {

            if ($direccion == null) {
                throw new Exception('Debe especificar una direccion.', 1);
            }

            if ($nombre == null) {
                throw new Exception('Debe especificar un nombre.', 1);
            }

            $suppliers = new Suppliers([
                'name' => $nombre,
                'address' => $direccion,
                'city' => $municipio,
                'email' => $correo,
                'cellphone' => $celular,
                'identType' => $tipoidentificacion,
                'ident' => $rnc
            ]);


            $suppliers->save();

        } catch (\Throwable $th) {
          //  var_dump($suppliers);

                       return redirect()->back() ->with('error',  $th->getMessage());

        }
    }
}
