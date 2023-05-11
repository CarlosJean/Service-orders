<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['identification', 'email', 'names', 'last_names', 'role_id','department_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    
    public function role(){
        return $this->belongsTo(Role::class);
    }
    
    public function department(){
        return $this->belongsTo(Department::class);
    }
}
