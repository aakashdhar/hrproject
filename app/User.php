<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'user_id';
    public $timestamps = true;

    protected $fillable = [
        'user_id', 'user_name', 'user_first_name', 'user_last_name', 'user_email',
        'user_type_id', 'user_status_id',
    ];

    protected $hidden = [
        'user_password', 'remember_token', 'user_password_raw'
    ];

    public function getAuthPassword()
    {
        return $this->user_password;
    }
}
