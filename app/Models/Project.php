<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS = [
        'done' => 'Done',
        'failed' => 'Failed',
        'pending' => 'Pending',
        'new' => 'New',
    ];

    protected $primaryKey = 'id';

    protected $table = 'dbuser.projects';
    protected $fillable = ['title', 'description', 'client', 'company', 'begin_at', 'finish_at'];
    protected $appends = ['status', 'duration'];
    public $timestamps = false;


    public function tasks(): HasMany
    {
        return $this->hasMany('App\Models\Task', 'id_project');
    }

    public function getStatusAttribute(): string
    {
        $incomplete_tasks = 0;

        foreach ($this->tasks as $task) {
            if (!$task->completed)
                $incomplete_tasks++;
        }

        if (Carbon::now() > $this->finish_at) {
            $status = $incomplete_tasks > 0 ? $this::STATUS['failed'] : $this::STATUS['done'];
        } else {
            $status = $incomplete_tasks > 0 ? $this::STATUS['pending'] : $this::STATUS['new'];
        }

        return $status;
    }

    public function getDurationAttribute(): string
    {
        return Carbon::parse($this->begin_at)->diffInDays($this->finish_at).' day(s)';
    }
}
