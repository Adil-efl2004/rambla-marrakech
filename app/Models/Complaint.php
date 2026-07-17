<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Complaint extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'room_id',
        'assigned_to',
        'type',
        'description',
        'priority',
        'status',
        'resolved_at',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'resolved_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * @return list<string>
     */
    public static function types(): array
    {
        return [
            'climatisation',
            'eau_chaude',
            'television',
            'wifi',
            'plomberie',
            'electricite',
            'autre',
        ];
    }

    /**
     * @return list<string>
     */
    public static function typesUrgentsParDefaut(): array
    {
        return [
            'climatisation',
            'eau_chaude',
            'plomberie',
            'electricite',
        ];
    }

    public function marquerResolue(): void
    {
        $this->update([
            'status' => 'resolue',
            'resolved_at' => now(),
        ]);
    }

    public function scopeUrgentes(Builder $query): Builder
    {
        return $query->where('priority', 'urgente');
    }

    public function scopeOuvertes(Builder $query): Builder
    {
        return $query->where('status', 'ouverte');
    }

    public function scopeEnCours(Builder $query): Builder
    {
        return $query->where('status', 'en_cours');
    }
}
