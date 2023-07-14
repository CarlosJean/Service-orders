<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class users_technician_services extends Model
{
    protected $fillable = [
        'Id',
        'employee_id',
        'service_id',
    ];

    use HasFactory;
}
