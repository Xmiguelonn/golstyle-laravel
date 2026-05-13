<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoPedido extends Model
{
    public $timestamps = false;
    protected $table = 'estado_pedido';
    protected $fillable = ['nombre'];

    const PENDIENTE  = 1;
    const ENVIADO    = 2;
    const ENTREGADO  = 3;
    const CANCELADO  = 4;
}
