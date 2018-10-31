<?php

namespace App\Models\Admins;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Admin extends Model
{
    use Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'user_id';
    public $timestamps = true;

    protected $fillable = [
        'user_id', 'user_name', 'user_first_name', 'user_last_name', 'user_email','user_contact_no',
        'user_address','user_type_id', 'user_status_id',
    ];

    protected $hidden = [
        'user_password', 'remember_token', 'user_password_raw'
    ];
}
