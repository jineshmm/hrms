<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Event;
use Carbon\Carbon;
use App\EmployeeLeaves;
use Illuminate\Http\Request;

use App\Http\Requests;

class ProfileController extends Controller
{
    public function show(){

        $details = Employee::where('user_id', \Auth::user()->id)->with('userrole.role')->first();

        $leaveTypeId =1;
        $count = EmployeeLeaves::where(['user_id' => \Auth::user()->id, 'leave_type_id' => $leaveTypeId, 'status' => '1'])->get();

        $day = 0;
        foreach ($count as $days) {
            $day += $days->days;
        }
        //calculate total leaves
        $yearlyLeaves = totalLeaves($leaveTypeId);
        $daydifference = Employee::where('user_id', \Auth::user()->id)->select(\DB::raw('DATEDIFF(now(),date_of_joining) as datediff'))->first();
        $totalDays = $daydifference->datediff;
         $totalLeaves = $totalDays * ($yearlyLeaves/365); 
        
        if($totalLeaves > 60) {
          $totalLeaves =60;   
        }
        $remainingLeaves = $totalLeaves - $day;
        
        
        
        
        $events = $this->convertToArray(Event::where('date', '>', Carbon::now())->orderBy('date','desc')->take(3)->get());
        return view('hrms.profile', compact('details','events','remainingLeaves'));
    }
    public function convertToArray($values)
    {
        $result = [];
        foreach($values as $key => $value)
        {
            $result[$key] = $value;
        }
        return $result;
    }
}
