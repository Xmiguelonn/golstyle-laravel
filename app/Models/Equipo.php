<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Equipo extends Model
{
    
    protected $table = 'equipo';
    protected $primaryKey = 'cod_equi';
    public $timestamps = false;

    protected $fillable = [
        'nombre', 
        'cod_lig'
    ];

    /**
     * Summary of liga
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Liga, Equipo>
     * 
     * ! Un equipo pertenece a una liga
     */
    public function liga(): BelongsTo {

        return $this->belongsTo(Liga::class, 'cod_lig');
    }

    /**
     * Summary of camisetas
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Camiseta, Equipo>
     * 
     * ! Un equipo tiene muchas camisetas
     */
    public function camisetas(): HasMany {

        return $this->hasMany(Camiseta::class, 'cod_equi');
    }

}
