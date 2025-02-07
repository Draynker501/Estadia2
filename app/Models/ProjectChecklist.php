<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectChecklist extends Model
{
    use HasFactory;

    protected $table = 'project_checklist';

    protected $fillable = ['project_id', 'checklist_id'];

    public $timestamps = false;
}
