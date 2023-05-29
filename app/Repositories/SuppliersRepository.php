<?php

namespace App\Repositories;

use App\Models\Suppliers;
use Exception;

class SuppliersRepository
{
    public function suppliers()
    {
        $suppliers = Suppliers::select('id','name', 'address','city','email','cellphone','ident','identType') ->where('active', 1)
            ->get();
            
        return $suppliers;
    }

    
    public function update($id)
    {
        try {

            $suppliers =  Suppliers::find($id);

            $suppliers->active = 0;

            $suppliers->save();
        } catch (\Throwable $th) {
            throw $th;
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

            throw $th;
        }
    }
}
