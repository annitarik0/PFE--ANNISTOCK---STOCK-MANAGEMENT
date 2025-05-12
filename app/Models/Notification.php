<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'message',
        'type',
        'icon',
        'is_read',
        // Removed 'link' as it doesn't exist in the database
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}