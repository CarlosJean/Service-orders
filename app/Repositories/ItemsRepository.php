<?php
namespace App\Repositories;

use App\Models\Item;
use Exception;

class ItemsRepository{    

    public function all(){
        return Item::get();
    }

    public function item($itemId){
        return Item::find($itemId);
    }


    
    public function update($id)
    {
        try {

            $model =  Item::find($id);

            $model->active = 0;

            $model->save();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    
    public function create($description, $nombre,$medida, $precio, $cantidad, $referencia)
    {
        try {

            if ($description == null) {
                throw new Exception('Debe especificar una descripcion.', 1);
            }

            if ($nombre == null) {
                throw new Exception('Debe especificar un nombre.', 1);
            }

            $model = new Item([
                'description' => $description,
                'name' => $nombre,
                'measurement_unit' =>$medida,
                'price' =>$precio, 
                'quantity' =>$cantidad,
                'reference' =>$referencia
            ]);

            $model->save();

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
