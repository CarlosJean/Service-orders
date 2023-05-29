<?php
namespace App\Repositories;

use App\Models\Item;

class ItemsRepository{    

    public function all(){
        return Item::get();
    }

    public function item($itemId){
        return Item::find($itemId);
    }
}
