<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccessLog extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

    protected $fillable = [
        'wallet_card_id',
        'door_id',
        'device_id',
        'result',
        'reason',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
        'created_at' => 'datetime',
    ];

    public function walletCard(): BelongsTo
    {
        return $this->belongsTo(WalletCard::class);
    }

    public function door(): BelongsTo
    {
        return $this->belongsTo(Door::class);
    }

    public function device(): BelongsTo
    {
        return $this->belongsTo(NfcDevice::class, 'device_id');
    }
}
