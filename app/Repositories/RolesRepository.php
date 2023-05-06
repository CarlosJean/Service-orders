<?php

namespace App\Repositories;

use App\Models\Role;

class RolesRepository
{
    public function roles(){
        $roles = Role::select('id','name')
            ->get();

        return $roles;
    }    
}
