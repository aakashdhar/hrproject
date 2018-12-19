<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskTimeline extends Model
{
    protected $table = 'user_task_timeline';
    protected $primaryKey = 'user_task_timeline_id';
    public $timestamps = false;

    protected $fillable = [
        'user_task_timeline_id', 'task_id', 'user_id', 'start_datetime',
        'halt_datetime', 'status_by_user'
    ];
}
