<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NfcDevice extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'reader_uid',
        'api_key_hash',
        'status',
    ];

    public function doors(): HasMany
    {
        return $this->hasMany(Door::class, 'device_id');
    }

    public function accessLogs(): HasMany
    {
        return $this->hasMany(AccessLog::class, 'device_id');
    }
}
