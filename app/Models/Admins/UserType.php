<?php

namespace App\Models\Admins;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    protected $table = 'user_types';
    protected $primaryKey = 'user_type_id';
    public $timestamps = true;


    protected $fillable = [
      'user_type_id', 'user_type', 'user_type_status','created_at','updated_at'
    ];
}
