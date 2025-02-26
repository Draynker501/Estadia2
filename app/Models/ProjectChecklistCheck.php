<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectChecklistCheck extends Model
{
    use HasFactory;

    protected $table = 'project_checklist_check';
    protected $fillable = ['project_project_checklist_id', 'project_check_id', 'checked'];

    public $timestamps = false;

    public function projectProjectChecklist()
    {
        return $this->belongsTo(related: ProjectProjectChecklist::class);
    }

    public function projectCheck()
    {
        return $this->belongsTo(ProjectCheck::class);
    }
}
