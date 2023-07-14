<?php

namespace App\Models;

use App\Enums\SystemRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['identification', 'email', 'names', 'last_names', 'role_id','department_id'];
    protected $appends  = ['system_role'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    
    public function role(){
        return $this->belongsTo(Role::class);
    }
    
    public function department(){
        return $this->belongsTo(Department::class);
    }

    public function services(){
        return $this->belongsToMany(Service::class);
    }

    public function getSystemRoleAttribute(){        
        $roleId = $this->attributes['role_id'];
        $departmentId = $this->attributes['department_id'];
        
        if($roleId == 1 && $departmentId == 1){ return SystemRoles::SystemAdmin;}
        if($roleId == 2 && $departmentId == 2){ return SystemRoles::MaintenanceSupervisor;}
        if($roleId == 3 && $departmentId == 2){ return SystemRoles::MaintenanceManager;}
        if($roleId == 4 && $departmentId != 2){ return SystemRoles::DepartmentSupervisor;}
        if($roleId == 5 && $departmentId != 2){ return SystemRoles::DepartmentManager;}
        if($roleId == 6 && $departmentId == 2){ return SystemRoles::MaintenanceTechnician;}
        if($roleId == 7 && $departmentId == 3){ return SystemRoles::Warehouseman;}
    }
}