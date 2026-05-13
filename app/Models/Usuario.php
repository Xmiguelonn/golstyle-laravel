<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        'rol_id',
    ];

    protected $hidden = [
        'password',
    ];

    // Accessor: $usuario->rol devuelve el nombre del rol como string
    public function getRolAttribute(): string
    {
        return $this->rolRelacion?->nombre ?? 'usuario';
    }

    // Mutator: $usuario->rol = 'admin' o update(['rol' => 'admin']) busca el ID automáticamente
    public function setRolAttribute(string $value): void
    {
        $this->attributes['rol_id'] = Rol::where('nombre', $value)->value('id');
    }

    public function isAdmin(): bool
    {
        return $this->rol_id === Rol::ADMIN;
    }

    public function rolRelacion(): BelongsTo
    {
        return $this->belongsTo(Rol::class, 'rol_id');
    }

    public function direcciones(): HasMany {
        return $this->hasMany(Direccion::class, 'cod_usu');
    }

    public function pedidos(): HasMany {
        return $this->hasMany(Pedido::class, 'cod_usu');
    }

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
