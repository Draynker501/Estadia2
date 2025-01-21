<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

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
            $customer->user_id = auth()->id(); // Establece el `user_id` automáticamente
        });
    }
}
