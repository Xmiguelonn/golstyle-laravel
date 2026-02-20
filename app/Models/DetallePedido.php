<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetallePedido extends Model
{
    
    protected $table = 'detalle_pedido';
    protected $primaryKey = 'cod_det_ped';
    public $timestamps = false;

    protected $fillable = [
        'precio_unid',
        'cantidad',
        'cod_ped',
        'cod_var',
        'nombre_personalizado',
        'dorsal_personalizado',
    ];


    /**
     * Summary of pedido
     * @return BelongsTo<Pedido, DetallePedido>
     * 
     * ! Un detalle de pedido pertenece a un pedido
     */
    public function pedido(): BelongsTo {

        return $this->belongsTo(Pedido::class, 'cod_ped');
    }

    /**
     * Summary of variante
     * @return BelongsTo<VarianteCamiseta, DetallePedido>
     * 
     * ! Un detalle de pedido pertenece a una variante
     */
    public function variante(): BelongsTo {

        return $this->belongsTo(VarianteCamiseta::class, 'cod_var');
    }


}
