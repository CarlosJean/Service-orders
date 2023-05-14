<?php

namespace App\Repositories;

use App\Models\Service;

class ServicesRepository{
    public function services(){
        return Service::get();
    }
}
