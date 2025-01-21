<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'last_name',
        'email',
        'phone',
        'status',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Establecer `user_id` automáticamente antes de crear un nuevo registro
    protected static function booted()
    {
        static::creating(function ($customer) {
            // Solo establece `user_id` si hay un usuario autenticado (esto evitará que falle en el seeder)
            if (auth()->check()) {
                $customer->user_id = auth()->id();
            }
        });
    }
}
