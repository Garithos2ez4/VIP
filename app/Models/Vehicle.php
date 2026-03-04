<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vehicle extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'placa',
        'marca',
        'modelo',
        'anio_fabricacion',
        'client_id',
    ];

    protected $casts = [
        'anio_fabricacion' => 'integer',
    ];

    /** @return BelongsTo<Client, Vehicle> */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
