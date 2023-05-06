<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['identification', 'email', 'names', 'last_names', 'role_id','department_id'];

    public function user(){
        return $this->hasOne(User::class);
    }
    
    public function role(){
        return $this->hasOne(Role::class);
    }
    
    public function Department(){
        return $this->hasOne(Role::class);
    }
}
