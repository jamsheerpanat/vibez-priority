<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'full_name',
        'email',
        'mobile',
        'user_type',
        'company_name',
        'status',
        'registered_via_qr',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (empty($user->uuid)) {
                $user->uuid = (string) Str::uuid();
            }
        });
    }

    public function walletCards(): HasMany
    {
        return $this->hasMany(WalletCard::class);
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
