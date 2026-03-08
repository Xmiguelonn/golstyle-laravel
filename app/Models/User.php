<?php

namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Sanctum\HasApiTokens;


class Usuario extends Authenticatable 
{
    use HasApiTokens; 

    protected $table = 'usuario';
    protected $primaryKey = 'cod_usu';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'ape1',
        'ape2',
        'correo',
        'password',
        'rol',
    ];

    
    protected $hidden = [
        'password',
    ];

    
    public function getAuthIdentifierName()
    {
        return 'correo'; 
    }

    /**
     * Summary of direcciones
     * @return HasMany<Direccion, Usuario>
     * * ! Un usuario tiene muchas direcciones
     */
    public function direcciones(): HasMany {
        return $this->hasMany(Direccion::class, 'cod_usu');
    }

    /**
     * Summary of pedidos
     * @return HasMany<Pedido, Usuario>
     * * ! Un usuario tiene muchos pedidos
     */
    public function pedidos(): HasMany {
        return $this->hasMany(Pedido::class, 'cod_usu');
    }

    /**
     * Summary of carrito
     * @return HasOne<Carrito, Usuario>
     * * ! Un usuario tiene un carrito
     */
    public function carrito(): HasOne {
        return $this->hasOne(Carrito::class, 'cod_usu');
    }
}