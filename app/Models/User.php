<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Admins\UserType;
use App\Models\Constants\UserType as Type;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'user_id';
    public $timestamps = true;

    protected $fillable = [
        'user_id', 'user_name', 'user_first_name', 'user_last_name', 'user_email',
        'user_type_id', 'user_status_id', 'user_contact_no', 'user_address', 'user_password', 'user_password_raw'
    ];

    protected $hidden = [
        'user_password', 'remember_token', 'user_password_raw'
    ];

    public function getAuthPassword()
    {
        return $this->user_password;
    }

    public function type() {
        return $this->hasOne(UserType::class, 'user_type_id', 'user_type_id');
    }

    public function getFullNameAttribute() {
        return ucwords($this->attributes['user_first_name']) . " " . ucwords($this->attributes['user_last_name']);
    }

    public function isAdmin()
    {
        return $this->user_type_id == Type::ADMIN;
    }
}
