<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'name', 'description'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function checklists()
    {
        return $this->hasMany(Checklist::class);
    }

    public function projectChecklists()
    {
        return $this->hasMany(ProjectChecklist::class);
    }

    public function notes()
    {
        return $this->morphMany(Note::class, 'notable');
    }
}
