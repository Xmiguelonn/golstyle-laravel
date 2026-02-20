<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ciudad extends Model
{
    protected $table = 'ciudad';
    protected $primaryKey = 'cod_ciu';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'cod_pro'
    ];

    /**
     * Summary of provincia
     * @return BelongsTo<Provincia, Ciudad>
     * 
     * ! Una ciudad pertenece a una provincia
     */
    public function provincia(): BelongsTo {

        return $this->belongsTo(Provincia::class, 'cod_pro');
    }

    /**
     * Summary of direcciones
     * @return HasMany<Direccion, Ciudad>
     * 
     * ! Una ciudad tiene muchas direcciones
     */
    public function direcciones() {

        return $this->hasMany(Direccion::class, 'cod_ciu');
    }
    

}
