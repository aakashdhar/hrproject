<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
  protected $table = 'user_designation';
  protected $primaryKey = 'user_designation_id';
  public $timestamps = true;

  protected $fillable = [
      'user_designation_id', 'user_designation_title', 'user_designation_status'
  ];
}
