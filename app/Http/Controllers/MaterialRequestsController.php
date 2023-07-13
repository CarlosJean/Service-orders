<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\MaterialsManagementRepository;
use Illuminate\Http\Request;

class MaterialRequestsController extends Controller
{

    public function __construct(protected MaterialsManagementRepository $materialsManagementRepository)
    {
    }

    public function index()
    {
        return view('materials_management.index');
    }

    public function pending()
    {
        $pendingMaterialsManagement = $this->materialsManagementRepository
            ->getPendings();

        return $pendingMaterialsManagement;
    }
}
