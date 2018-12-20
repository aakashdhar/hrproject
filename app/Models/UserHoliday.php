<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class UserHoliday extends Model
{
    protected $table = 'user_holiday';
    protected $primaryKey = 'user_holiday_id';
    public $timestamps = true;

    protected $fillable = [
        'user_holiday_id',
        'user_id',
        'user_holiday_from',
        'user_holiday_to',
        'user_holiday_docname',
        'user_holiday_subject',
        'user_holiday_reason',
        'user_holiday_count',
        'user_holiday_approval_status',
        'created_at',
        'updated_at'
    ];

    public function relation()
    {
        return $this->hasMany(User::class, 'user_id', 'user_id');
    }

    public function user() {
        return $this->hasOne(User::class, 'user_id', 'user_id');
    }
}
