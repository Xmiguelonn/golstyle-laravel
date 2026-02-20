<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Liga extends Model
{
    protected $table = 'liga';
    protected $primaryKey = 'cod_lig';
    public $timestamps = false;

    protected $fillable = [
        'nombre'
    ];

    /**
     * Summary of equipos
     * @return HasMany<Equipo, Liga>
     * 
     * ! Una liga tiene muchos equipos
     */
    public function equipos(): HasMany {

        return $this->hasMany(Equipo::class, 'cod_lig');
    }


}
