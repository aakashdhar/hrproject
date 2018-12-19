<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    protected $table = "tasks";
    protected $primaryKey = "task_id";
    public $timestamps = true;

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

    public function user()
    {
        
    }
}
