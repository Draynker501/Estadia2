<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectChecklistCheck extends Model
{
    use HasFactory;

    protected $table = 'project_checklist_check';
    protected $fillable = ['project_checklist_rel_id', 'project_check_id', 'checked'];

    public $timestamps = false;

    public function projectChecklistRel()
    {
        return $this->belongsTo(related: ProjectChecklistRel::class);
    }

    public function projectCheck()
    {
        return $this->belongsTo(ProjectCheck::class);
    }
}
