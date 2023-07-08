<?php

namespace App\Http\Controllers;

use App\Enums\systemRoles;
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

        $isDepartmentSupervisor = ($employee['system_role'] == systemRoles::DepartmentSupervisor || $employee['system_role'] == systemRoles::DepartmentManager);        
        $isMaintenanceSupervisor = ($employee['system_role'] == SystemRoles::MaintenanceSupervisor || $employee['system_role'] == SystemRoles::MaintenanceManager);        
        $isWarehouseEmployee = ($employee['system_role'] == systemRoles::Warehouseman);        
        $isMaintenanceTechnician = ($employee['system_role'] == SystemRoles::MaintenanceTechnician);
        $isSystemAdmin = ($employee['system_role'] == systemRoles::SystemAdmin);

        return view('home')->with([
            'isDepartmentSupervisor' => $isDepartmentSupervisor,
            'isMaintenanceSupervisor' => $isMaintenanceSupervisor,
            'isWarehouseEmployee' => $isWarehouseEmployee,
            'isMaintenanceTechnician' => $isMaintenanceTechnician,
            'isSystemAdmin' => $isSystemAdmin,
        ]);
    }
}
