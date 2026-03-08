<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    use HasFactory;

    protected $table = 'direccion';
    protected $primaryKey = 'cod_dir';
    public $timestamps = false;

    protected $fillable = [
        'calle',
        'num',
        'piso',
        'cp',
        'telefono',
        'ciudad',
        'provincia',
        'cod_usu'
    ];

    /**
     * Relación: una dirección pertenece a un usuario
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'cod_usu', 'cod_usu');
    }
}
