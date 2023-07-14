<?php

namespace App\Http\Controllers;

use App\Enums\SystemRoles;
use App\Http\Controllers\Controller;
use App\Repositories\EmployeeRepository;
use App\Repositories\MaterialsManagementRepository;
use Illuminate\Http\Request;

class MaterialRequestsController extends Controller
{

    public function __construct(
        protected MaterialsManagementRepository $materialsManagementRepository,
        protected EmployeeRepository $employeeRepository)
    {
    }

    public function index()
    {
        return view('materials_management.index');
    }

    public function pending()
    {
        $userId = auth()->id();
        $systemRole = $this->employeeRepository->employeeSystemRole($userId);

        $pendingMaterialsManagement = $this->materialsManagementRepository
            ->getPendings();

        foreach ($pendingMaterialsManagement as $key => $row) {
            $pendingMaterialsManagement[$key]->status = strtoupper($row->status);
        }
        
        $data = [
            'user_system_role' => $systemRole, 
            'data' => $pendingMaterialsManagement, 
        ];
        
        return $data;
    }
}
