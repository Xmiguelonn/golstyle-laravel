<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificacionMail;
use Illuminate\Support\Facades\URL;

class Usuario extends Authenticatable implements MustVerifyEmail 
{
    use HasApiTokens, Notifiable;
    
    protected $table = 'usuario';
    protected $primaryKey = 'cod_usu';
    public $timestamps = false;

    public function getRouteKeyName(): string { return 'cod_usu'; }

    protected $fillable = [
        'nombre',
        'ape1',
        'ape2',
        'correo',
        'password',
        'rol',
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * ! Un usuario tiene muchas direcciones
     */
    public function direcciones(): HasMany {
        return $this->hasMany(Direccion::class, 'cod_usu');
    }

    /**
     * ! Un usuario tiene muchos pedidos
     */
    public function pedidos(): HasMany {
        return $this->hasMany(Pedido::class, 'cod_usu');
    }

    /**
     * ! Un usuario tiene un carrito
     */
    public function carrito(): HasOne {
        return $this->hasOne(Carrito::class, 'cod_usu');
    }

    public function sendEmailVerificationNotification()
    {
        $urlLaravel = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $this->getKey(), 'hash' => sha1($this->getEmailForVerification())]
        );

        $urlAngular = "http://localhost:4217/verificar-email?url=" . urlencode($urlLaravel);

        Mail::to($this->correo)->send(new VerificacionMail($this, $urlAngular));
    }

    public function getEmailForVerification()
    {
        return $this->correo;
    }

    public function routeNotificationForMail($notification)
    {
        return $this->correo;
    }

    public function hasVerifiedEmail()
    {
        return ! is_null($this->email_verified_at);
    }
}