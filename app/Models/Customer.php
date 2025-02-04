<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

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

    protected $casts = [
        'status' => 'boolean', // Cast automático a booleano
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

    public function scopeFilterByAuthor($query)
    {
        $user = auth()->user();

        // Aplica el filtro solo si hay un usuario autenticado y tiene el rol "Autor"
        if ($user && $user->hasRole('Autor')) {
            return $query->where('user_id', $user->id);
        }

        return $query;
    }

    public function projects(){
        return $this->belongsToMany(Project::class,'customer_projects');
    }
}
