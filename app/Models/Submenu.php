<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submenu extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'name'];

    
    public function menu(){
        return $this->belongsTo(Menu::class);
    }

    public function roles(){
        return $this->belongsToMany(Role::class);
    }
}
