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

    protected static $priorityValues = [
        'B' => 'Baixa',
        'M' => 'Média',
        'A' => 'Alta',
    ];

    public function getPriorityAttribute($value)
    {
        return static::$priorityValues[$value];
    }

    protected static $statusValues = [
        'P' => 'Pendente',
        'A' => 'Andamento',
        'C' => 'Concluída',
    ];

    public function getStatusAttribute($value)
    {
        return static::$statusValues[$value];
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'due_date' => 'date:d/m/Y',
        ];
    }


    /**
     * Define a relação entre ProjectTasks e User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Define a relação entre ProjectTasks e Project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    /**
     * Define a relação entre ProjectTasks e ProjectMembers.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function members()
    {
        return $this->hasMany(ProjectMembers::class, 'project_id');
    }
}
