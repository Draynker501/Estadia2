<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectCheck extends Model
{
    use HasFactory;

    protected $fillable = ['project_checklist_id','name','required'];

    protected $casts = [
        'required' => 'boolean',
    ];

    public $timestamps = false;

    public function projectChecklist()
    {
        return $this->belongsTo(ProjectChecklist::class);
    }

    public function projectChecklistChecks()
    {
        return $this->hasMany(ProjectChecklistCheck::class, 'project_check_id');
    }
}
