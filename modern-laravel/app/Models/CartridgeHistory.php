<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartridgeHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'cartridge_id',
        'owner',
        'weight_before',
        'weight_after',
        'date_outcome',
        'date_income',
        'servicename',
        'technical_life',
        'log',
        'log_full',
        'date_of_changes',
    ];

    protected $casts = [
        'date_outcome' => 'date',
        'date_income' => 'date',
        'date_of_changes' => 'date',
        'technical_life' => 'integer',
        'weight_before' => 'integer',
        'weight_after' => 'integer',
    ];

    /**
     * Get the cartridge that owns the history.
     */
    public function cartridge(): BelongsTo
    {
        return $this->belongsTo(Cartridge::class);
    }

    /**
     * Calculate weight difference.
     */
    public function getWeightDifferenceAttribute(): int
    {
        return $this->weight_after - $this->weight_before;
    }
}
