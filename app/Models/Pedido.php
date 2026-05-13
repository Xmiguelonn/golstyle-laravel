<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pedido extends Model
{
    protected $table = 'pedido';
    protected $primaryKey = 'cod_ped';
    public $timestamps = false;

    public function getRouteKeyName(): string { return 'cod_ped'; }

    protected $fillable = [
        'fecha',
        'total',
        'estado',
        'estado_id',
        'cod_usu',
        'cod_dir',
    ];

    // Incluir 'estado' (string) en la serialización JSON para la API de Angular
    protected $appends = ['estado'];

    // Accessor: $pedido->estado devuelve el nombre del estado como string
    public function getEstadoAttribute(): string
    {
        return $this->estadoObj?->nombre ?? 'pendiente';
    }

    // Mutator: $pedido->estado = 'cancelado' o update(['estado' => '...']) busca el ID automáticamente
    public function setEstadoAttribute(string $value): void
    {
        $this->attributes['estado_id'] = EstadoPedido::where('nombre', $value)->value('id');
    }

    public function esPendiente(): bool
    {
        return $this->estado_id === EstadoPedido::PENDIENTE;
    }

    public function esCancelado(): bool
    {
        return $this->estado_id === EstadoPedido::CANCELADO;
    }

    public function estadoObj(): BelongsTo
    {
        return $this->belongsTo(EstadoPedido::class, 'estado_id');
    }

    public function detalles(): HasMany {
        return $this->hasMany(DetallePedido::class, 'cod_ped');
    }

    public function usuario(): BelongsTo {
        return $this->belongsTo(Usuario::class, 'cod_usu');
    }

    public function direccion(): BelongsTo {
        return $this->belongsTo(Direccion::class, 'cod_dir')->withDefault();
    }
}
