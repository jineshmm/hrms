<?php

namespace App;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;

class EmployeeLeaves extends Model
{
    public function leaveType()
    {
        return $this->hasOne('App\Models\LeaveType', 'id', 'leave_type_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function tickets()
    {
        return $this->hasOne('App\Models\Ticketdetails', 'leave_id');
    }
    public function exitReentry()
    {
        return $this->hasOne('App\Models\Exitrentrydetails', 'leave_id');
    }
}
