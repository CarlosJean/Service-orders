<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;    
    protected $fillable = ['name','description','active'];

    public function submenus(){
        return $this->belongsToMany(Submenu::class);
    }
}
