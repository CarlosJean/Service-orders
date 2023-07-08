<?php

namespace App\Http\Controllers;

use App\Repositories\EmployeeRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected EmployeeRepository $employeeRepository)
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $userId = auth()->id();

        $employee = $this->employeeRepository->employeeByUserId($userId);

        $isDepartmentSupervisor = (($employee['roleId'] == 2 || $employee['roleId'] == 3) 
        && $employee['department']->id != 2);
        
        $isMaintenanceSupervisor = (($employee['roleId'] == 2 || $employee['roleId'] == 3) 
        && $employee['department']->id == 2);

        $isWarehouseEmployee = ($employee['roleId'] == 5 && $employee['department']->id == 3);
        $isMaintenanceTechnician = ($employee['roleId'] == 4 && $employee['department']->id == 2);

        return view('home')->with([
            'isDepartmentSupervisor' => $isDepartmentSupervisor,
            'isMaintenanceSupervisor' => $isMaintenanceSupervisor,
            'isWarehouseEmployee' => $isWarehouseEmployee,
            'isMaintenanceTechnician' => $isMaintenanceTechnician,
        ]);
    }
}
