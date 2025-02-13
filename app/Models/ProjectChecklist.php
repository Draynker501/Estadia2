<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class ProjectChecklist extends Model
{
    use HasFactory;

    protected $table = 'project_checklists';

    protected $fillable = ['project_id', 'checklist_id', 'orden', 'completed'];

    protected $casts = [
        'required' => 'boolean',
    ];

    public $timestamps = false;

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function checklist()
    {
        return $this->belongsTo(Checklist::class);
    }

    public function checkStatuses()
    {
        return $this->hasMany(CheckStatus::class, 'project_checklist_id');
    }

    // 🔹 Obtener todos los Checks del Checklist
    public function checks()
    {
        return $this->hasManyThrough(Check::class, Checklist::class, 'id', 'checklist_id', 'checklist_id', 'id');
    }

    public function isCompleted()
    {
        $checklistId = $this->checklist_id;

        $requiredCheckIds = Check::where('checklist_id', $checklistId)
            ->where('required', true)
            ->pluck('id')
            ->toArray();

        $allCheckIds = Check::where('checklist_id', $checklistId)
            ->pluck('id')
            ->toArray();

        $checkedRequiredChecks = CheckStatus::where('project_checklist_id', $this->id)
            ->whereIn('check_id', $requiredCheckIds)
            ->where('checked', true)
            ->count();

        $checkedAllChecks = CheckStatus::where('project_checklist_id', $this->id)
            ->whereIn('check_id', $allCheckIds)
            ->where('checked', true)
            ->count();

        return ($checkedRequiredChecks === count($requiredCheckIds)) || ($checkedAllChecks === count($allCheckIds));
    }


    protected static function booted()
    {
        static::creating(function ($model) {
            if (!$model->orden) { // Si no tiene 'orden', asignar el siguiente disponible
                $maxOrder = ProjectChecklist::where('project_id', $model->project_id)
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
