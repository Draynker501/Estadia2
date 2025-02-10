<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    protected static function booted()
    {
        static::creating(function ($model) {
            if (!$model->orden) { // Si no tiene 'orden', asignar el siguiente disponible
                $maxOrder = ProjectChecklist::where('project_id', $model->project_id)
                    ->max('orden'); // Obtener el mayor orden existente en ese proyecto

                $model->orden = ($maxOrder ?? 0) + 1; // Evitar valores NULL y asignar 1 si es el primer registro
            }
        });
    }
}
