<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Direccion extends Model
{
    protected $table = 'direccion';
    protected $primaryKey = 'cod_dir';
    public $timestamps = false;

    protected $fillable = [
        'calle',
        'num',
        'piso',
        'cp',
        'cod_usu',
        'cod_ciu',
    ];

    /**
     * Summary of ciudad
     * @return BelongsTo<Ciudad, Direccion>
     * 
     * ! Una dirección pertenece a una ciudad
     */
    public function ciudad(): BelongsTo {

        return $this->belongsTo(Ciudad::class, 'cod_ciu');
    }

    /**
     * Summary of usuario
     * @return BelongsTo<Usuario, Direccion>
     * 
     * ! Una dirección pertenece a un usuario
     */
    public function usuario(): BelongsTo {

        return $this->belongsTo(Usuario::class, 'cod_usu');
    }

}
