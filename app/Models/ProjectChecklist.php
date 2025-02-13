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
        return $this->hasMany(CheckStatus::class,'project_checklist_id');
    }

    // 🔹 Obtener todos los Checks del Checklist
    public function checks()
    {
        return $this->hasManyThrough(Check::class, Checklist::class, 'id', 'checklist_id', 'checklist_id', 'id');
    }

    public function isCompleted()
    {
        return DB::table('check_status as cs')
            ->join('checks as c', 'cs.check_id', '=', 'c.id')
            ->where('cs.project_checklist_id', $this->id)
            ->where('c.required', true)
            ->where('cs.checked', false)
            ->count() === 0;
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
