<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogTask extends Model
{
    protected $table = "log_task_details";
    protected $primaryKey = "log_task_details_id";
    public $timestamps = false;

    protected $with = ['task'];

    protected $fillable = [
        'log_task_details_id',
        'log_task_id',
        'log_task_started_at',
        'log_task_finished_at'
    ];

    public function task() {
        return $this->hasOne(Tasks::Class,'task_id','log_task_id');
    }
}
