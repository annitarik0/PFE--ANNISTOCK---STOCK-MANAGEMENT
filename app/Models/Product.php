<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'price',
        'category_id',
        // Removed 'category' as it doesn't exist in the database
        'quantity',
        'image',
        'description'
        // Removed 'min_stock' as it doesn't exist in the database
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'price' => 'decimal:2', // Ensures price is always treated as decimal
        'quantity' => 'integer'
    ];

    /**
     * Relationship to Category
     */
    public function category():BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Accessor for formatted price
     */
    public function getFormattedPriceAttribute()
    {
        return '$' . number_format($this->price, 2);
    }

    /**
     * Scope for available products (quantity > 0)
     */
    public function scopeAvailable($query)
    {
        return $query->where('quantity', '>', 0);
    }

    /**
     * Scope for expensive products (price > $100)
     */
    public function scopeExpensive($query)
    {
        return $query->where('price', '>', 100);
    }
}
