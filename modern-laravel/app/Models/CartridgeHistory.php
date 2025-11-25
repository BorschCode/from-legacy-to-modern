<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $cartridge_id
 * @property string $owner Location or owner according to inventory records
 * @property int $weight_before Weight before sending to the service center
 * @property int $weight_after Weight after refilling
 * @property \Illuminate\Support\Carbon|null $date_outcome Date sent to the service center
 * @property \Illuminate\Support\Carbon|null $date_income Date received from the service center
 * @property string $servicename Service center performing repair/refill
 * @property int $technical_life Cartridge condition: active (1) or inactive (0)
 * @property string|null $log Short change history: records only keys and values that were modified
 * @property string|null $log_full Full change log: records all data before and after each edit
 * @property \Illuminate\Support\Carbon|null $date_of_changes Date when changes were made
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Cartridge $cartridge
 * @property-read int $weight_difference
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartridgeHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartridgeHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartridgeHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartridgeHistory whereCartridgeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartridgeHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartridgeHistory whereDateIncome($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartridgeHistory whereDateOfChanges($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartridgeHistory whereDateOutcome($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartridgeHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartridgeHistory whereLog($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartridgeHistory whereLogFull($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartridgeHistory whereOwner($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartridgeHistory whereServicename($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartridgeHistory whereTechnicalLife($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartridgeHistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartridgeHistory whereWeightAfter($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CartridgeHistory whereWeightBefore($value)
 * @mixin \Eloquent
 */
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
