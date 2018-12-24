<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class QuickTask extends Model
{
    public $timestamps = true;
    protected $table = 'user_quicktask';
    protected $primaryKey = 'user_quicktask_id';
    protected $fillable = [
        'user_quicktask_content', 'user_quicktask_userid'
    ];

    public function user(){
      return $this->hasOne(User::class, 'user_id', 'user_quicktask_userid');
    }
}
