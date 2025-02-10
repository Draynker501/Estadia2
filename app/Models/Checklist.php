<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    use HasFactory;

    protected $fillable = ['task'];

    public $timestamps = false;

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_checklists', 'checklist_id', 'project_id');
    }

    public function checks()
    {
        return $this->hasMany(Check::class);
    }
}
