<?php

namespace App\Http\Controllers;

use App\Exceptions\NoUserEmailException;
use App\Exceptions\UniqueColumnException;
use App\Http\Requests\CreateEmployeeRequest;
use App\Models\Employee;
use App\Repositories\DepartmentsRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\RolesRepository;
use OutOfRangeException;

class EmployeesController extends Controller
{

    protected $rolesRepository;
    protected $employeeRepository;
    protected $departmentsRepository;
    protected $deparmentsAndRoles;

    public function __construct(
        RolesRepository $rolesRepository,
        EmployeeRepository $employeeRepository,
        DepartmentsRepository $departmentsRepository
    ) {
        $this->rolesRepository = $rolesRepository;
        $this->employeeRepository = $employeeRepository;
        $this->departmentsRepository = $departmentsRepository;
    }

    public function index($id = null)
    {
        if (auth()->guest()) {
            return redirect('login');
        }

        $roles = $this->rolesRepository->roles();
        $deparments = $this->departmentsRepository->departments();
        $viewModel = array(
            'roles' => $roles,
            'departments' => $deparments,
        );

        try {

            if ($id == null) return view('employees.register')->with($viewModel);

            $employee = $this->employeeRepository->employeeById($id);
            if ($employee != null) {

                if ($employee == null) {
                    throw new OutOfRangeException();
                }

                $viewModel += ['employee' => $employee];

                return view('employees.register')
                    ->with($viewModel);
            }
        } catch (OutOfRangeException) {
            return redirect('registro-empleado')->with($viewModel);
        }
    }

    public function store(CreateEmployeeRequest $request)
    {
        try {
            $employee = new Employee($request->except('_token'));
            $employee->id = $request->input('id', 0);
            $createUser = $request->input('create_user') != null;

            $this->employeeRepository->create($employee, $createUser);

            $employeeName = $request->input('names') . ' ' . $request->input('last_names');
            return view('employees.created')->with(['employee_name' => $employeeName, 'employee_id' => $employee->id]);
        } catch (UniqueColumnException $e) {
            return back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        } catch (NoUserEmailException $e) {
            return back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        } catch (\Exception $e) {
            return back()
                ->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function getEmployees()
    {
        $employees = $this->employeeRepository
            ->employees();

        echo json_encode($employees);
    }

    public function list()
    {
        return view('employees.list');
    }
}
