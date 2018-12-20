<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\TaskTimeline;

class Tasks extends Model
{
    protected $table = "tasks";
    protected $primaryKey = "task_id";
    public $timestamps = true;

    protected $with = ['assigner', 'assignedTo'];

    protected $fillable = [
        'task_id',
        'task_title',
        'task_description',
        'task_created_by',
        'task_assigned_to',
        'task_assigned_by',
        'created_at',
        'updated_at'
    ];

    public function assigner() {
        return $this->hasOne(User::class, 'user_id', 'task_created_by');
    }

    public function assignedTo()
    {
        return $this->hasOne(User::class, 'user_id', 'task_assigned_to');
    }
    public function timeline() {
        return $this->hasMany(LogTask::class, 'log_task_id', 'task_id');
    }
    public function user()
    {

    }
}
