<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'created_by',
        'order_id',
        'total',
    ];

    public function details(){
        return $this->hasMany(QuoteDetail::class);
    }

}
