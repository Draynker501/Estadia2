<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectChecklistRel extends Model
{
    use HasFactory;

    protected $table = 'project_checklist_rel';

    protected $fillable = ['project_id', 'project_checklist_id', 'orden', 'completed'];

    protected $casts = [
        'completed' => 'boolean',
    ];

    public $timestamps = false;

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function projectChecklist()
    {
        return $this->belongsTo(ProjectChecklist::class);
    }

    public function projectChecklistChecks()
    {
        return $this->hasMany(ProjectChecklistCheck::class, 'project_checklist_rel_id');
    }

    // 🔹 Obtener todos los Checks del Checklist
    public function projectChecks()
    {
        return $this->hasManyThrough(ProjectCheck::class, ProjectChecklist::class, 'id', 'project_checklist_id', 'project_checklist_id', 'id');
    }

    public function isCompleted()
    {
        $checklistId = $this->project_checklist_id;

        $requiredCheckIds = ProjectCheck::where('project_checklist_id', $checklistId)
            ->where('required', true)
                ->pluck('id')
            ->toArray();

        $allCheckIds = ProjectCheck::where('project_checklist_id', $checklistId)
            ->pluck('id')
            ->toArray();

        $checkedRequiredChecks = ProjectChecklistCheck::where('project_checklist_rel_id', $this->id)
            ->whereIn('project_check_id', $requiredCheckIds)
            ->where('checked', true)
            ->count();

        $checkedAllChecks = ProjectChecklistCheck::where('project_checklist_rel_id', $this->id)
            ->whereIn('project_check_id', $allCheckIds)
            ->where('checked', true)
            ->count();

        return ($checkedRequiredChecks === count($requiredCheckIds)) || ($checkedAllChecks === count($allCheckIds));
    }


    protected static function booted()
    {
        static::creating(function ($model) {
            if (!$model->orden) { // Si no tiene 'orden', asignar el siguiente disponible
                $maxOrder = ProjectChecklistRel::where('project_id', $model->project_id)
                    ->max('orden'); // Obtener el mayor orden existente en ese proyecto

                $model->orden = ($maxOrder ?? 0) + 1; // Evitar valores NULL y asignar 1 si es el primer registro
            }
        });

        static::updated(function ($model) {
            // Actualizar automáticamente el campo "completed"
            $model->completed = $model->isCompleted();
            $model->saveQuietly(); // Evita ciclos infinitos al guardar
        });
    }
}
