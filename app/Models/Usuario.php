<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Usuario extends Model
{
    
    protected $table = 'usuario';
    protected $primaryKey = 'cod_usu';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'ape1',
        'ape2',
        'correo',
        'password',
        'telefono',
        'rol',
    ];

    /**
     * Summary of direcciones
     * @return HasMany<Direccion, Usuario>
     * 
     * ! Un usuario tiene muchas direcciones
     */
    public function direcciones(): HasMany {

        return $this->hasMany(Direccion::class, 'cod_usu');
    }

    /**
     * Summary of pedidos
     * @return HasMany<Pedido, Usuario>
     * 
     * ! Un usuario tiene muchos pedidos
     */
    public function pedidos(): HasMany {

        return $this->hasMany(Pedido::class, 'cod_usu');
    }

    /**
     * Summary of carrito
     * @return HasOne<Carrito, Usuario>
     * 
     * ! Un usuario tiene un carrito
     */
    public function carrito(): HasOne {

        return $this->hasOne(Carrito::class, 'cod_usu');
    }

}
