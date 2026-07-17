<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'room_id',
        'served_by',
        'status',
        'total_amount',
        'notes',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'total_amount' => 'decimal:2',
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

    public function servedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'served_by');
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function recalculateTotal(): void
    {
        $total = $this->items()
            ->selectRaw('SUM(quantity * unit_price) as total')
            ->value('total') ?? 0;

        $this->update(['total_amount' => $total]);
    }

    public function scopeEnCours(Builder $query): Builder
    {
        return $query->whereIn('status', ['recue', 'en_preparation', 'en_livraison']);
    }

    public function scopeLivrees(Builder $query): Builder
    {
        return $query->where('status', 'livree');
    }
}
