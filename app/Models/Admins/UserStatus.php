<?php

namespace App\Models\Admins;

use Illuminate\Database\Eloquent\Model;

class UserStatus extends Model
{
    protected $table = 'user_status';
    protected $primaryKey = 'user_status_id';

    protected $fillable = [
      'user_status_id',
    ];

}
