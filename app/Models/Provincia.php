<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Provincia extends Model
{
    
    protected $table = 'provincia';
    protected $primaryKey = 'cod_pro';
    public $timestamps = false;

    protected $fillable = [
        'nombre'
    ];

    /**
     * Summary of ciudades
     * @return HasMany<Ciudad, Provincia>
     * 
     * !Una provinvia tiene muchas ciudades
     */
    public function ciudades(): HasMany {

        return $this->hasMany(Ciudad::class, 'cod_pro');
    }

}
