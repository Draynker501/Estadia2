<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description','customer_id'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function checklist()
    {
        return $this->belongsToMany(Checklist::class, 'project_checklist');
    }
}
