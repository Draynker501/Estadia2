<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as ModelsPermission;

class permission extends ModelsPermission
{
    use HasFactory;
}
