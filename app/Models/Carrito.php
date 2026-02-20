<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Carrito extends Model
{
    protected $table = 'carrito';
    protected $primaryKey = 'cod_carr';
    public $timestamps = false;
    protected $fillable = [
        'cod_usu',
        'fecha_creacion',
    ];

    /**
     * Summary of detalles
     * @return HasMany<DetalleCarrito, Carrito>
     * 
     * ! Un carrito tiene muchos detalles
     */
    public function detalles(): HasMany {

        return $this->hasMany(DetalleCarrito::class, 'cod_carr');
    }

    /**
     * Summary of usuario
     * @return BelongsTo<Usuario, Carrito>
     * 
     * ! Un carrito pertenece a un usuario
     */
    public function usuario(): BelongsTo {

        return $this->belongsTo(Usuario::class, 'cod_usu');
    }

}
