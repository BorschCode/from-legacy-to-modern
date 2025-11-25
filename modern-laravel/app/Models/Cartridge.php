<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
                'log' => 'Cartridge created on ' . now()->format('d.m.Y'),
                'log_full' => 'Initial record created on ' . now()->format('d.m.Y'),
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
