<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employee_service extends Model
{

    protected $fillable = [
        'id',
        'employee_id',
        'service_id',
    ];
    use HasFactory;
}
