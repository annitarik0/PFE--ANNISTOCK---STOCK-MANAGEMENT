<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'total_amount',
        'status',
        'notes',
    ];

    /**
     * Get the user that owns the order.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the order items for the order.
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Calculate the total amount of the order.
     */
    public function calculateTotal(): float
    {
        return $this->items->sum(function ($item) {
            return $item->quantity * $item->price;
        });
    }

    /**
     * Update the order status.
     */
    public function updateStatus(string $status): void
    {
        $this->status = $status;
        $this->save();
    }

    /**
     * Get the display name for the order.
     * Returns the custom name if set and if the column exists, otherwise returns "Order #ID".
     */
    public function getDisplayName(): string
    {
        // Check if the name attribute exists and has a value
        if (isset($this->attributes['name']) && !empty($this->attributes['name'])) {
            return $this->attributes['name'];
        }

        return 'Order #' . $this->id;
    }
}
