<?php

namespace App\Repositories;

use App\Models\Employee;

class EmployeeRepository
{
    
    public function employeeByUserId($userId){  
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

    public function create(Employee $employee){

        try {

            $newEmployee = new Employee([
                'identification' => $employee->identification,
                'names' => $employee->names,
                'last_names' => $employee->last_names,
                'email' => $employee->email,
                'department_id' => $employee->department_id,
                'role_id' => $employee->role_id,
            ]);
            //var_dump($newEmployee);
            $newEmployee->save();
        } catch (\Throwable $th) {
            var_dump($th);
            //throw $th;
        }
    }
}
