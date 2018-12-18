<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Tasks extends Model
{
    protected $table = "tasks";
    protected $primaryKey = "task_id";
    public $timestamps = true;

    protected $fillable = [
        'task_id', 'user_id', 'task', 'start_datetime', 'end_datetime', 'status_by_admin', 
        'comments_by_admin','created_at','updated_at'
    ];

    public function user()
    {
        return $this->hasOne(User::class,"user_id","user_id");
    }
}
