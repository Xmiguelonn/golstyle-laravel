<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetalleCarrito extends Model
{
    protected $table = 'detalle_carrito';
    protected $primaryKey = 'cod_det_carr';
    public $timestamps = false;

    protected $fillable = [
        'cod_carr',
        'cod_var',
        'cantidad',
        'fecha_agregado',
        'nombre_personalizado',
        'dorsal_personalizado',
    ];

    /**
     * Summary of carrito
     * @return BelongsTo<Carrito, DetalleCarrito>
     * 
     * ! Un detalle de carrito pertenece a un carrito
     */
    public function carrito(): BelongsTo {

        return $this->belongsTo(Carrito::class, 'cod_carr');
    }

    /**
     * Summary of variante
     * @return BelongsTo<VarianteCamiseta, DetalleCarrito>
     * 
     * ! Un detalle del carrito pertenece a una variante de camiseta
     */
    public function variante(): BelongsTo {

        return $this->belongsTo(VarianteCamiseta::class, 'cod_var');
    }



}
