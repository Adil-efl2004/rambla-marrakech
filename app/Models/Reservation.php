<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Reservation extends Model
{
    /**
     * Délai minimum avant arrivée pour autoriser l'annulation par le client (en heures).
     */
    public const CANCELLATION_DEADLINE_HOURS = 24;
    /**
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'reservable_type',
        'reservable_id',
        'start_datetime',
        'end_datetime',
        'status',
        'total_price',
        'notes',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_datetime' => 'datetime',
            'end_datetime' => 'datetime',
            'total_price' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reservable(): MorphTo
    {
        return $this->morphTo();
    }

    public function scopeEnAttente(Builder $query): Builder
    {
        return $query->where('status', 'en_attente');
    }

    public function scopeConfirmees(Builder $query): Builder
    {
        return $query->where('status', 'confirmee');
    }

    public function scopeActives(Builder $query): Builder
    {
        return $query->whereIn('status', ['en_attente', 'confirmee']);
    }

    /**
     * Indique si le client peut encore annuler cette réservation.
     *
     * Conditions :
     *  - status en_attente ou confirmee
     *  - arrivée à plus de CANCELLATION_DEADLINE_HOURS heures dans le futur
     */
    public function isCancellableByClient(): bool
    {
        if (! in_array($this->status, ['en_attente', 'confirmee'], true)) {
            return false;
        }

        return $this->start_datetime->isAfter(
            now()->addHours(self::CANCELLATION_DEADLINE_HOURS)
        );
    }
}
