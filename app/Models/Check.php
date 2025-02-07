<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Check extends Model
{
    use HasFactory;

    protected $fillable = ['checklist_id','name','required'];

    protected $casts = [
        'required' => 'boolean',
    ];

    public $timestamps = false;

    public function checklist()
    {
        return $this->belongsTo(Checklist::class);
    }
}
