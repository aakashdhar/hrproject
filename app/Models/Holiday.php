<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    public $timestamps = false;
    protected $table = 'holiday';
    protected $primaryKey = 'holiday_id';
    protected $fillable = [
        'holiday_id', 'holiday_name', 'holiday_date', 'office_location_id', 'holiday_status'
    ];
    protected $hidden = [];
}
