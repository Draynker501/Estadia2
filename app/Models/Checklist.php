<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    use HasFactory;

    protected $fillable = ['task', 'orden'];

    public $timestamps = false;

    public function project()
    {
        return $this->belongsToMany(Project::class, 'project_checklist', 'checklist_id', 'project_id');
    }

    public function checks()
    {
        return $this->hasMany(Check::class);
    }
}
