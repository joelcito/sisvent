<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'productos';

    public function categoria(){
        return $this->belongsTo('App\Models\Categoria', 'categoria_id');
    }

    public function sucursal(){
        return $this->belongsTo('App\Models\Sucursal', 'sucursal_id');
    }
   
}
