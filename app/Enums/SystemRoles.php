<?php 

namespace App\Enums;

Enum SystemRoles{
    case DepartmentSupervisor;
    case DepartmentManager;
    case MaintenanceManager;
    case MaintenanceSupervisor;
    case MaintenanceTechnician;
    case SystemAdmin;
    case Warehouseman;
}