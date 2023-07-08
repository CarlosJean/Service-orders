<?php

namespace App\Repositories;

use App\Enums\SystemRole;
use App\Exceptions\NotFoundModelException;
use App\Exceptions\NoUserEmailException;
use App\Exceptions\UniqueColumnException;
use App\Models\Employee;
use App\Models\Service;
use App\Models\User;
use App\Notifications\RegisteredUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use OutOfRangeException;
use Illuminate\Support\Str;

class EmployeeRepository
{

    public function employees()
    {
        $employees = DB::table('employees')
            ->join('departments', 'employees.department_id', '=', 'departments.id')
            ->join('roles', 'employees.role_id', '=', 'roles.id')
            ->leftJoin('users', 'employees.user_id', '=', 'users.id')
            ->select(
                'employees.id',
                'names',
                'last_names',
                'identification',
                'employees.email',
                'departments.name as department',
                'roles.name as role',
                DB::raw('(CASE WHEN user_id IS NULL then "No" ELSE "Sí" END) as has_user ')
            )
            ->get();

        return $employees;
    }

    public function employeeByUserId($userId)
    {
        try {

            $employeeModel =  Employee::where('user_id', $userId)
                ->first();

            if ($employeeModel == null) {
                throw new NotFoundModelException('No se encontró el usuario buscado.');
            }

            $employee = array(
                'id' => $employeeModel->id,
                'roleId' => $employeeModel->role_id,
                'user_id' => $employeeModel->user_id,
                'names' => $employeeModel->names,
                'last_names' => $employeeModel->last_names,
                'identification' => $employeeModel->identification,
                'email' => $employeeModel->email,
                'department' => $employeeModel->department,
                'role' => $employeeModel->role,
                'system_role' => $employeeModel->system_role
            );

            return $employee;
        } catch (\Throwable $th) {
            //var_dump($th);
            throw $th;
        }
    }

    public function create(Employee $employee, $createUser = false)
    {

        try {

            if ($employee->id != null) {
                $this->updateEmployee($employee, $createUser);
            } else {
                $this->createEmployee($employee, $createUser);
            }
        } catch (UniqueColumnException $e) {
            throw $e;
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    private function createEmployee(Employee $employee, $createUser = false)
    {
        try {
            $emailRegistered = Employee::where('email', $employee->email)->first();

            if (isset($emailRegistered)) {
                $message = 'Ya existe un empleado con el correo ' . $employee->email . '.';
                throw new UniqueColumnException($message);
            }

            $identificationRegistered = Employee::where('identification', $employee->identification)->first();
            if (isset($identificationRegistered)) {
                $message = 'Ya existe un empleado con el documento de identificación no. ' . $employee->identification . '.';
                throw new UniqueColumnException($message);
            }

            $newEmployee = new Employee([
                'identification' => $employee->identification,
                'names' => $employee->names,
                'last_names' => $employee->last_names,
                'email' => $employee->email,
                'department_id' => $employee->department_id,
                'role_id' => $employee->role_id,
            ]);

            if ($createUser && $employee->email == null) {
                throw new NoUserEmailException();
            }

            if ($createUser) {
                $userName = $employee->names . ' ' . $employee->last_names;
                $password =  Str::random(10); 

                $newUser = new User([
                    'name' => $userName,
                    'email' => $employee->email,
                    'password' => Hash::make($password),
                ]);
                $newUser->save();

                $newEmployee->user_id = $newUser->id;

                //Enviar notificación al correo
                $newUser->notify(new RegisteredUser($password));
            }

            $newEmployee->save();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    private function updateEmployee($employee, $createUser = false)
    {
        try {

            if ($createUser && $employee->email == null) {
                throw new NoUserEmailException();
            }

            $employeeIdByEmail = Employee::where('email', $employee->email)
                ?->select('id')
                ?->first()
                ?->id;

            if ($employee->email != null && $employeeIdByEmail != null && $employeeIdByEmail != $employee->id) {
                $message = 'Ya existe un empleado con el correo ' . $employee->email . '.';
                throw new UniqueColumnException($message);
            }

            $updatedEmployee = $this->employeeById($employee->id);
            $updatedEmployee->identification = $employee->identification;
            $updatedEmployee->names = $employee->names;
            $updatedEmployee->last_names = $employee->last_names;
            $updatedEmployee->email = $employee->email;
            $updatedEmployee->department_id = $employee->department_id;
            $updatedEmployee->role_id = $employee->role_id;

            //Si el correo electrónico del empleado cambió lo actualizamos en la tabla de usuarios
            if ($employee->email != null && $employee->user != null) {
                $user = User::find($updatedEmployee->user->id);
                $user->name = $employee->names . ' ' . $employee->last_names;
                $user->email = $employee->email;

                $user->save();
            } else if ($createUser && $employee->user == null) {
                //Si se solicita crear el usuario pero el empleado no tiene entonces se crea 
                //el nuevo usuario para el empleado.

                $password = Str::random(10);
                $user = new User([
                    'name' => $employee->names . ' ' . $employee->last_names,
                    'email' => $employee->email,
                    'password' => Hash::make($password),
                ]);
                $user->save();
                $updatedEmployee->user_id = $user->id;

                //Enviar notificación al correo
                $user->notify(new RegisteredUser($password));
            }

            $updatedEmployee->save();
        } catch (UniqueColumnException $ex) {
            throw $ex;
        } catch (\Throwable $th) {
            var_dump($th);
            //throw $th;
        }
    }

    public function employeeById($id): Employee
    {
        try {
            return Employee::find($id);
        } catch (\Throwable $th) {
            throw new OutOfRangeException();
        }
    }

    public function employeesByService($serviceId)
    {

        $employeesByService = Service::with('employees')
            ->where('id', $serviceId)
            ->first()
            ->employees;

        $employees = [];
        foreach ($employeesByService as $employee) {
            array_push($employees, [
                'id' => $employee->user->id,
                'name' => $employee->names . ' ' . $employee->last_names,
            ]);
        }

        return $employees;
    }

    public function employeeByRoleAndDepartment($roleId, $departmentId){
        $employees = Employee::where('role_id', $roleId)
            ->where('department_id', $departmentId);
        
        return $employees;
    }
}
