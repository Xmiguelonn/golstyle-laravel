<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Usuario extends Authenticatable 
{
    use HasApiTokens, Notifiable;
    
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

    /**
     * ! Un usuario tiene muchas direcciones
     */
    public function direcciones(): HasMany {
        return $this->hasMany(Direccion::class, 'cod_usu');
    }

    /**
     * ! Un usuario tiene muchos pedidos
     */
    public function pedidos(): HasMany {
        return $this->hasMany(Pedido::class, 'cod_usu');
    }

    /**
     * ! Un usuario tiene un carrito
     */
    public function carrito(): HasOne {
        return $this->hasOne(Carrito::class, 'cod_usu');
    }
}