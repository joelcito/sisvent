<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Venta extends Model
{
    use HasFactory, SoftDeletes;

    public function cliente(){
        return $this->belongsTo('App\Models\Cliente', 'cliente_id');
    }

    /**
     * Relación uno a muchos con Detalle.
     */
    public function detalles()
    {
        return $this->hasMany(Detalle::class, 'venta_id', 'id');
    }

}
