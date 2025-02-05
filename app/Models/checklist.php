<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class checklist extends Model
{
    use HasFactory;

    protected $fillable = ['project_step_id', 'task', 'checked'];

    protected $casts = [
        'checked' => 'boolean',
    ];

    public function projectSteps()
    {
        return $this->belongsTo(ProjectSteps::class);
    }

    public function setCheckedAttribute($value)
    {
        $this->attributes['checked'] = $value;

        if ($value) {
            // Verificar si ya hay 2 tareas checked en este paso
            if ($this->projectStep->checklists()->where('checked', true)->count() >= 2) {
                $this->projectStep->update(['completed' => true]);
            }
        }
    }
}
