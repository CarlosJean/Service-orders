<?php 

namespace App\Enums;

Enum SystemRoles : string{
    case DepartmentSupervisor = 'departmentsupervisor';
    case DepartmentManager = 'departmentmanager';
    case MaintenanceManager = 'maintenancemanager';
    case MaintenanceSupervisor = 'maintenancesupervisor';
    case MaintenanceTechnician = 'maintenancetechnician';
    case SystemAdmin = 'systemadmin';
    case Warehouseman = 'warehouseman';
}