<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\permission as ModelsPermission;

class permission extends ModelsPermission
{
    use HasFactory, SoftDeletes;
}
