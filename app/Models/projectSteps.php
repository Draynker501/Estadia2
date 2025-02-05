<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class projectSteps extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'name', 'order', 'completed'];

    public $timestamps = false;

    protected $casts = [
        'completed' => 'boolean',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function checklists()
    {
        return $this->hasMany(Checklist::class);
    }

    // Verifica si al menos 2 tareas están marcadas como 'checked'
    public function canAdvance()
    {
        return $this->checklists()->where('checked', true)->count() >= 2;
    }

    public function markCompleted()
    {
        if ($this->canAdvance()) {
            $this->update(['completed' => true]);
        }
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($step) {
            // Obtener el máximo "order" del mismo "project_id"
            $maxOrder = self::where('project_id', $step->project_id)->max('order');
            $step->order = $maxOrder ? $maxOrder + 1 : 1;
        });
    }
}
