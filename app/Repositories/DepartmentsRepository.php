<?php

namespace App\Repositories;

use App\Models\Department;

class DepartmentsRepository
{
    public function departments()
    {
        $departments = Department::select('name', 'id')
            ->get();
            
        return $departments;
    }
}
