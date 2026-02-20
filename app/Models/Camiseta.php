<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Camiseta extends Model
{
    protected $table = 'camiseta';
    protected $primaryKey = 'cod_cam';
    public $timestamps = false;

    protected $fillable = [
        'color', 
        'cod_equi', 
        'cod_sel', 
        'cod_tem', 
        'imagen_principal'
        ];

    /**
     * Summary of variantes
     * @return HasMany<VarianteCamiseta, Camiseta>
     * 
     * ! Una camiseta tiene muchas variantes
     */
    public function variantes(): HasMany {

        return $this->hasMany(VarianteCamiseta::class, 'cod_cam');
    }

    public function imagenes() {

        return $this->hasMany(ImagenCamiseta::class, 'cod_cam');
    }

    /**
     * Summary of temporada
     * @return BelongsTo<Temporada, Camiseta>
     * 
     * ! Una camiseta pertenece a una temporada
     */
    public function temporada(): BelongsTo {

        return $this->belongsTo(Temporada::class, 'cod_tem');
    }

    /**
     * Summary of seleccion
     * @return BelongsTo<Seleccion, Camiseta>
     * 
     * ! Una camiseta pertenece a una seleccion
     */
    public function seleccion(): BelongsTo {

        return $this->belongsTo(Seleccion::class, 'cod_sel');
    }

    /**
     * Summary of equipo
     * @return BelongsTo<Equipo, Camiseta>
     * 
     * ! Una camiseta pertenece a un equipo
     */
    public function equipo(): BelongsTo {

        return $this->belongsTo(Equipo::class, 'cod_equi');
    }


}
