<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pedido extends Model
{
    protected $table = 'pedido';
    protected $primaryKey = 'cod_ped';
    public $timestamps = false;

    protected $fillable = [
        'fecha',
        'total',
        'estado',
        'cod_usu',
        'cod_dir',
    ];


    /**
     * Summary of detalles
     * @return HasMany<DetalleCarrito, Pedido>
     * 
     * ! Un pedido tiene muchos detalles
     */
    public function detalles(): HasMany {

        return $this->hasMany(DetallePedido::class, 'cod_ped');
    }

    /**
     * Summary of usuario
     * @return BelongsTo<Usuario, Pedido>
     * 
     * ! Un pedido pertenece a un usuario
     */
    public function usuario(): BelongsTo {

        return $this->belongsTo(Usuario::class, 'cod_usu');
    }

    /**
     * Summary of direccion
     * @return BelongsTo<Direccion, Pedido>
     * 
     * ! Un pedido pertenece a una dirección
     */
    public function direccion(): BelongsTo {

        return $this->belongsTo(Direccion::class, 'cod_dir');
    }


}
