<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VarianteCamiseta extends Model
{
    protected $table = 'variantes_camiseta';
    protected $primaryKey = 'cod_var';
    public $timestamps = false;

    protected $fillable = ['cod_cam', 'talla', 'stock', 'precio'];

    /**
     * Summary of camiseta
     * @return BelongsTo<Camiseta, VarianteCamiseta>
     * 
     * ! Una variante de camiseta pertenece a una camiseta
     */
    public function camiseta(): BelongsTo {

        return $this->belongsTo(Camiseta::class, 'cod_cam');
    }


}
