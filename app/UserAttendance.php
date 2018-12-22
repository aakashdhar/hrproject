<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAttendance extends Model
{
/**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "user_attendance";

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'attendance_id';


    protected $fillable = [
        'user_id','date','attendance_status'
    ];
}
