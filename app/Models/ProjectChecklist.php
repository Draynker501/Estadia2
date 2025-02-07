<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectChecklist extends Model
{
    use HasFactory;

    protected $table = 'project_checklist';

    protected $fillable = ['project_id', 'checklist_id','orden','completed'];

    protected $casts = [
        'required' => 'boolean',
    ];

    public $timestamps = false;
}
