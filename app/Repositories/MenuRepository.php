<?php

namespace App\Repositories;

class MenuRepository{
    
    
    public static function submenusByRole(){

        
        return ['Menu', 'Other menu',auth()->id()];
    }

}