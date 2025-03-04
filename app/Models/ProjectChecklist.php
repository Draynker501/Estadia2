<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectChecklist extends Model
{
    use HasFactory;

    protected $fillable = ['task','is_cloned'];

    public $timestamps = false;

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_checklist_rel', 'project_checklist_id', 'project_id');
    }

    public function projectChecks()
    {
        return $this->hasMany(ProjectCheck::class);
    }

    public function notes()
    {
        return $this->morphMany(Note::class, 'notable');
    }

    public function projectProjectChecklists()
    {
        return $this->hasMany(ProjectProjectChecklist::class);
    }
}
