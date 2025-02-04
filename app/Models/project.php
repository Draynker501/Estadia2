<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class project extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function customers(){
        return $this->belongsToMany(Customer::class,'customer_projects');
    }

    public function steps()
    {
        return $this->hasMany(ProjectSteps::class);
    }
}
