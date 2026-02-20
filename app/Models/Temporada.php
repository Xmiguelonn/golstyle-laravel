<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Temporada extends Model
{
    protected $table = 'temporada';
    protected $primaryKey = 'cod_tem';
    public $timestamps = false;

    protected $fillable = [
        'inicio', 
        'fin'
    ];

    /**
     * Summary of camisetas
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Camiseta, Temporada>
     * 
     * ! Una temporada tiene muchas camisetas
     */
    public function camisetas(): HasMany {

        return $this->hasMany(Camiseta::class, 'cod_tem');
    }

}
