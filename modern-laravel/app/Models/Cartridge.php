<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $owner Location or owner according to inventory records
 * @property string $brand Manufacturer of the cartridge
 * @property string $marks Model of the cartridge assigned by the manufacturer
 * @property int $weight_before Weight before sending to the service center
 * @property int $weight_after Weight after refilling
 * @property \Illuminate\Support\Carbon|null $date_outcome Date sent to the service center
 * @property \Illuminate\Support\Carbon|null $date_income Date received from the service center
 * @property string|null $servicename Service center performing repair/refill
 * @property string|null $comments Comments describing the cartridge status
 * @property int $technical_life Cartridge condition: in use (1) or decommissioned (0)
 * @property string $code Unique cartridge code or inventory number
 * @property int $inservice Service status: 1 - in service, 0 - not in service (auto-calculated)
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int $weight_difference
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CartridgeHistory> $histories
 * @property-read int|null $histories_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cartridge newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cartridge newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cartridge query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cartridge whereBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cartridge whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cartridge whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cartridge whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cartridge whereDateIncome($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cartridge whereDateOutcome($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cartridge whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cartridge whereInservice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cartridge whereMarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cartridge whereOwner($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cartridge whereServicename($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cartridge whereTechnicalLife($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cartridge whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cartridge whereWeightAfter($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cartridge whereWeightBefore($value)
 *
 * @mixin \Eloquent
 */
class Cartridge extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner',
        'brand',
        'marks',
        'weight_before',
        'weight_after',
        'date_outcome',
        'date_income',
        'servicename',
        'comments',
        'technical_life',
        'code',
        'inservice',
    ];

    protected $casts = [
        'date_outcome' => 'date',
        'date_income' => 'date',
        'technical_life' => 'integer',
        'inservice' => 'integer',
        'weight_before' => 'integer',
        'weight_after' => 'integer',
    ];

    /**
     * Get the histories for the cartridge.
     */
    public function histories(): HasMany
    {
        return $this->hasMany(CartridgeHistory::class)->orderBy('created_at', 'desc');
    }

    /**
     * Calculate weight difference.
     */
    public function getWeightDifferenceAttribute(): int
    {
        return $this->weight_after - $this->weight_before;
    }

    /**
     * Check if cartridge is in service.
     */
    public function updateServiceStatus(): void
    {
        if ($this->date_outcome && $this->date_income) {
            $this->inservice = $this->date_income < $this->date_outcome ? 1 : 0;
        } else {
            $this->inservice = 0;
        }
    }

    /**
     * Boot method to handle events.
     */
    protected static function boot()
    {
        parent::boot();

        static::updating(function ($cartridge) {
            // Auto-calculate service status
            $cartridge->updateServiceStatus();

            // Log changes to history
            $cartridge->logChanges();
        });

        static::created(function ($cartridge) {
            // Create initial history record
            CartridgeHistory::create([
                'cartridge_id' => $cartridge->id,
                'owner' => $cartridge->owner,
                'weight_before' => $cartridge->weight_before,
                'weight_after' => $cartridge->weight_after,
                'date_outcome' => $cartridge->date_outcome,
                'date_income' => $cartridge->date_income,
                'servicename' => $cartridge->servicename,
                'technical_life' => $cartridge->technical_life,
                'log' => 'Cartridge created on '.now()->format('d.m.Y'),
                'log_full' => 'Initial record created on '.now()->format('d.m.Y'),
                'date_of_changes' => now(),
            ]);
        });
    }

    /**
     * Log changes to history table.
     */
    protected function logChanges(): void
    {
        $original = $this->getOriginal();
        $changes = $this->getDirty();

        if (empty($changes)) {
            return;
        }

        $log = [];
        $logFull = [];

        foreach ($changes as $key => $newValue) {
            if (isset($original[$key])) {
                $oldValue = $original[$key];
                $log[] = "{$key}: {$oldValue} → {$newValue}";
                $logFull[] = "Changed {$key} from '{$oldValue}' to '{$newValue}'";
            }
        }

        CartridgeHistory::create([
            'cartridge_id' => $this->id,
            'owner' => $this->owner,
            'weight_before' => $this->weight_before,
            'weight_after' => $this->weight_after,
            'date_outcome' => $this->date_outcome,
            'date_income' => $this->date_income,
            'servicename' => $this->servicename ?? 'Log update',
            'technical_life' => $this->technical_life,
            'log' => implode(', ', $log),
            'log_full' => implode('; ', $logFull),
            'date_of_changes' => now(),
        ]);
    }
}
