<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    public $timestamps = false;
    protected $table = 'rol';
    protected $fillable = ['nombre'];

    const USUARIO = 1;
    const ADMIN   = 2;
}
