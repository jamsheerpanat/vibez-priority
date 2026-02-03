<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccessPermission extends Model
{
    use HasFactory;

    protected $fillable = [
        'wallet_card_id',
        'door_id',
        'valid_from',
        'valid_to',
        'time_start',
        'time_end',
    ];

    protected $casts = [
        'valid_from' => 'datetime',
        'valid_to' => 'datetime',
    ];

    public function walletCard(): BelongsTo
    {
        return $this->belongsTo(WalletCard::class);
    }

    public function door(): BelongsTo
    {
        return $this->belongsTo(Door::class);
    }
}
