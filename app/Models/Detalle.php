<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detalle extends Model
{
    use HasFactory, SoftDeletes;

    public function producto(){
        return $this->belongsTo('App\Models\Product', 'producto_id');
    }
}