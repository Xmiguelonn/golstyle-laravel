<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Seleccion extends Model
{
    protected $table = 'seleccion';

    protected $primaryKey = 'cod_sel';

    public $timestamps = false;
    protected $fillable = [
        'nombre'
    ];

    /**
     * Summary of camisetas
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Camiseta, Seleccion>
     * 
     * ! Una selección tiene muchas camisetas
     */
    public function camisetas(): HasMany {

        return $this->hasMany(Camiseta::class, 'cod_sel');
    }
}
