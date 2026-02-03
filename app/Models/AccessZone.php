<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AccessZone extends Model
{
    use HasFactory;

    protected $fillable = [
        'zone_name',
        'description',
    ];

    public function doors(): HasMany
    {
        return $this->hasMany(Door::class, 'zone_id');
    }

    public function qrSources(): HasMany
    {
        return $this->hasMany(QrSource::class, 'assigned_zone_id');
    }
}
