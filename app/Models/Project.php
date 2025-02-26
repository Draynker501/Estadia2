<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Str;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'name', 'description'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function projectChecklists()
    {
        return $this->hasMany(ProjectChecklist::class);
    }

    public function projectProjectChecklists()
    {
        return $this->hasMany(ProjectProjectChecklist::class);
    }

    public function notes()
    {
        return $this->morphMany(Note::class, 'notable');
    }

    public function projectChecklistChecks()
    {
        return $this->hasMany(ProjectChecklistCheck::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($project) {
            $slug = Str::slug($project->name);
            $count = Project::where('slug', 'like', $slug . '%')->count();
            $project->slug = $count ? "{$slug}-{$count}" : $slug;
        });

        static::updating(function ($project) {
            if ($project->isDirty('name')) {
                $slug = Str::slug($project->name);
                $count = Project::where('slug', 'like', $slug . '%')
                    ->where('id', '!=', $project->id)
                    ->count();
                $project->slug = $count ? "{$slug}-{$count}" : $slug;
            }
        });
    }

    // Método para personalizar la obtención de la clave en las rutas de Filament
    public function getRouteKeyName()
    {
        return 'slug'; // Indica que Filament debe buscar por el slug en lugar del ID
    }
}
