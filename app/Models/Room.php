<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Room extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'number',
        'floor',
        'type',
        'status',
        'price_per_night',
        'wifi_vlan',
        'surface_m2',
        'capacity',
        'bed_type',
        'amenities',
        'description',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'floor'           => 'integer',
            'price_per_night' => 'decimal:2',
            'surface_m2'      => 'integer',
            'capacity'        => 'integer',
            'amenities'       => 'array',
        ];
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(RoomPhoto::class)->orderBy('position');
    }

    public function reservations(): MorphMany
    {
        return $this->morphMany(Reservation::class, 'reservable');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function complaints(): HasMany
    {
        return $this->hasMany(Complaint::class);
    }

    // ── Scopes statut ─────────────────────────────────────────────────────────

    public function scopeLibres(Builder $query): Builder
    {
        return $query->where('status', 'libre');
    }

    public function scopeOccupees(Builder $query): Builder
    {
        return $query->where('status', 'occupee');
    }

    public function scopeEnMaintenance(Builder $query): Builder
    {
        return $query->where('status', 'maintenance');
    }

    // ── Disponibilité par dates ────────────────────────────────────────────────

    /**
     * Vérifie qu'aucune réservation active ne chevauche la période demandée.
     *
     * Logique : (existing.start < new.end) AND (existing.end > new.start)
     * Si $end est null, on considère une nuit (start + 1 jour).
     *
     * Les deux cas (avec/sans end_datetime) sont combinés dans UNE seule requête
     * avec un orWhere imbriqué, puis la négation est appliquée UNE seule fois
     * sur le exists() final — ce qui évite le bug !A || !B.
     */
    public function isAvailable(string|\DateTimeInterface $start, string|\DateTimeInterface|null $end = null): bool
    {
        $start = \Carbon\Carbon::parse($start);
        $end   = $end ? \Carbon\Carbon::parse($end) : $start->copy()->addDay();

        $hasConflict = $this->reservations()
            ->whereIn('status', ['en_attente', 'confirmee'])
            ->where(function (Builder $query) use ($start, $end) {
                // Cas 1 : réservation avec date de fin explicite — chevauchement standard
                $query->where(function (Builder $q) use ($start, $end) {
                    $q->whereNotNull('end_datetime')
                      ->where('start_datetime', '<', $end)
                      ->where('end_datetime', '>', $start);
                })
                // Cas 2 : réservation sans date de fin (nuit implicite = start + 1 jour)
                ->orWhere(function (Builder $q) use ($start, $end) {
                    $q->whereNull('end_datetime')
                      ->whereBetween('start_datetime', [$start, $end->copy()->subSecond()]);
                });
            })
            ->exists();

        return ! $hasConflict;
    }

    /**
     * Filtre les chambres sans chevauchement sur la période donnée.
     * Utilise une sous-requête Eloquent pour rester en dehors du SQL brut.
     */
    public function scopeAvailableBetween(Builder $query, string|\DateTimeInterface $start, string|\DateTimeInterface $end): Builder
    {
        $start = \Carbon\Carbon::parse($start);
        $end   = \Carbon\Carbon::parse($end);

        // Exclut les chambres ayant au moins une réservation active qui chevauche
        return $query->whereDoesntHave('reservations', function (Builder $q) use ($start, $end) {
            $q->whereIn('status', ['en_attente', 'confirmee'])
              ->where(function (Builder $inner) use ($start, $end) {
                  // Réservations avec date de fin explicite
                  $inner->where(function (Builder $withEnd) use ($start, $end) {
                      $withEnd->whereNotNull('end_datetime')
                               ->where('start_datetime', '<', $end)
                               ->where('end_datetime', '>', $start);
                  })
                  // Réservations sans date de fin (nuit implicite = start + 1 jour)
                  ->orWhere(function (Builder $noEnd) use ($start, $end) {
                      $noEnd->whereNull('end_datetime')
                            ->whereBetween('start_datetime', [$start, $end->copy()->subSecond()]);
                  });
              });
        });
    }
}
