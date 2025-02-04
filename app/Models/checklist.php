<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class checklist extends Model
{
    use HasFactory;

    protected $fillable = ['project_step_id', 'task', 'checked'];

    public function projectSteps()
    {
        return $this->belongsTo(ProjectSteps::class);
    }
}
