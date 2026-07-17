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
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'floor' => 'integer',
            'price_per_night' => 'decimal:2',
        ];
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
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
}
