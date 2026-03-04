<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre',
        'apellidos',
        'nro_documento',
        'correo',
        'telefono',
    ];

    /** @return HasMany<Vehicle> */
    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class);
    }

    /** Full name helper */
    public function getFullNameAttribute(): string
    {
        return "{$this->nombre} {$this->apellidos}";
    }
}
