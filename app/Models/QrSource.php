<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QrSource extends Model
{
    use HasFactory;

    protected $fillable = [
        'source_code',
        'description',
        'assigned_zone_id',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function assignedZone(): BelongsTo
    {
        return $this->belongsTo(AccessZone::class, 'assigned_zone_id');
    }
}
