<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class RoleSubmenu extends Model
{
    use HasFactory;

    protected $fillable = ['role_id','submenu_id'];
    protected $table = 'role_submenu';

}
