<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEmployeeRequest;
use App\Models\Employee;
use App\Repositories\DepartmentsRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\RolesRepository;

class EmployeesController extends Controller
{

    protected $rolesRepository;
    protected $employeeRepository;
    protected $departmentsRepository;
    public function __construct(
        RolesRepository $rolesRepository,
        EmployeeRepository $employeeRepository,
        DepartmentsRepository $departmentsRepository
    ) {
        $this->rolesRepository = $rolesRepository;
        $this->employeeRepository = $employeeRepository;
        $this->departmentsRepository = $departmentsRepository;
    }

    public function index()
    {
        $roles = $this->rolesRepository->roles();
        $deparments = $this->departmentsRepository->departments();

        return view('employees.register')->with(array(
            'roles' => $roles,
            'departments' => $deparments
        ));
    }

    public function store(CreateEmployeeRequest $request)
    {
        $employee = new Employee($request->except('_token'));
        $this->employeeRepository->create($employee);

        $roles = $this->rolesRepository->roles();   
        $deparments = $this->departmentsRepository->departments();

        return view('employees.register')->with(array(
            'roles' => $roles,
            'departments' => $deparments
        ));
    }
}
