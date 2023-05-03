<?php

namespace App\Repositories;

use App\Models\Employee;

class EmployeerRepository
{
    public function employeerByUserId($userId){  
        $employeeModel =  Employee::where('user_id', $userId)->first();

        $employee = array(
            'id' => $employeeModel->id,
            'roleId' => $employeeModel->role_id,
            'user_id' => $employeeModel->user_id,
            'names' => $employeeModel->names,
            'last_names' => $employeeModel->last_names,
            'identification' => $employeeModel->identification,
            'email' => $employeeModel->email,
        );

        return $employee;
    }
}
