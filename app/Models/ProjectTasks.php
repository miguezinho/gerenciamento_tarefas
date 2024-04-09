<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectTasks extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'user_id',
        'title',
        'description',
        'due_date',
        'priority',
        'status',
    ];
}
