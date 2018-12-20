<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use app\Models\User;

class Reminder extends Model
{
  protected $table = 'user_reminder';
  protected $primaryKey = 'user_reminder_id';
  public $timestamps = true;
  protected $with = ['user'];

  protected $fillable = [
      'user_reminder_id', 'user_id', 'user_reminder_details', 'user_remind_on', 'user_reminder_status'
  ];

  public function user() {
      return $this->hasOne(User::class, 'user_id', 'user_id');
  }

}
