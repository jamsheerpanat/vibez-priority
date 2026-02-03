<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Door extends Model
{
    use HasFactory;

    protected $fillable = [
        'zone_id',
        'device_id',
        'door_name',
        'status',
    ];

    public function zone(): BelongsTo
    {
        return $this->belongsTo(AccessZone::class, 'zone_id');
    }

    public function device(): BelongsTo
    {
        return $this->belongsTo(NfcDevice::class, 'device_id');
    }

    public function accessPermissions(): HasMany
    {
        return $this->hasMany(AccessPermission::class);
    }

    public function accessLogs(): HasMany
    {
        return $this->hasMany(AccessLog::class);
    }
}
