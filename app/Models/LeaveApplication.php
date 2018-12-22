<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class LeaveApplication extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "leave_applications";

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'leave_id';


    protected $fillable = [

        'applicant_id', 'approver_id', 'from_date', 'to_date', 'total_days',

        'status', 'reason', 'is_read', 'approval_comment',

        'cancel_reason', 'created_at'
    ];

    private static $_status = [

        'Pending' => 'Pending',

        'Approved' => 'Approved',

        'Rejected' => 'Rejected',

        'Cancelled' => 'Cancelled'
    ];

    private static $i = 0;

    public function applicant()
    {
        return $this->hasOne(User::class, 'user_id', 'applicant_id');
    }

    public function approver()
    {
        return $this->hasOne(User::class, 'user_id', 'approver_id');
    }

    public function getFromDateAttribute()
    {
        return isset($this->attributes['from_date']) ? format_date($this->attributes['from_date']) : "";
    }

    public function getToDateAttribute()
    {
        return isset($this->attributes['to_date']) ? format_date($this->attributes['to_date']) : "";
    }

    public function getCreatedAtAttribute()
    {
        return isset($this->attributes['created_at']) ? format_datetime($this->attributes['created_at']) : "";
    }

    public function getApprovalCommentAttribute()
    {
        return !empty($this->attributes['approval_comment']) ? $this->attributes['approval_comment'] : 'N/A';
    }

    public function getCancelReasonAttribute()
    {
        return !empty($this->attributes['cancel_reason']) ? $this->attributes['cancel_reason'] : 'N/A';
    }
}
