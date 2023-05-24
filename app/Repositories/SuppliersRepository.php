<?php 

namespace App\Repositories;

use App\Models\Supplier;

class SuppliersRepository{
    
    public function all(){
        return Supplier::get();
    }

}
