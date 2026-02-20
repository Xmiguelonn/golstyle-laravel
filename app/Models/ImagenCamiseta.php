<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImagenCamiseta extends Model
{
    protected $table = 'imagenes_camiseta';
    protected $primaryKey = 'cod_img';
    public $timestamps = false;

    protected $fillable = [
        'cod_cam',
        'imagen',
    ];

    /**
     * Summary of camiseta
     * @return BelongsTo<Camiseta, ImagenCamiseta>
     * 
     * ! Una imagen de camiseta pertenece a una camiseta
     */
    public function camiseta(): BelongsTo {

        return $this->belongsTo(Camiseta::class, 'cod_cam');
    }


}
