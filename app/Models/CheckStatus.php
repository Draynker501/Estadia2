<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckStatus extends Model
{
    use HasFactory;

    protected $table = 'check_status';
    protected $fillable = ['project_checklist_id', 'check_id', 'checked'];

    public function projectChecklist()
    {
        return $this->belongsTo(ProjectChecklist::class);
    }

    public function check()
    {
        return $this->belongsTo(Check::class);
    }
}
