<?php

namespace App\Http\Controllers;

use App\EmployeeLeaves;
use App\LeaveDraft;
use App\Models\Employee;
use App\Models\Holiday;
use App\Models\HolidayFilenames;
use App\Models\LeaveType;
use App\Models\Team;
use App\User;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class LeaveController extends Controller {

    /**
     * LeaveController constructor.
     * @param Mailer $mailer
     */
    public function __construct(Mailer $mailer) {
        $this->mailer = $mailer;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addLeaveType() {
        return view('hrms.leave.add_leave_type');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    Public function processLeaveType(Request $request) {
        $leave = new LeaveType;
        $leave->leave_type = $request->leave_type;
        $leave->description = $request->description;
        $leave->save();

        \Session::flash('flash_message', 'Leave Type successfully added!');
        return redirect()->back();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLeaveType() {
        $leaves = LeaveType::paginate(10);
        return view('hrms.leave.show_leave_type', compact('leaves'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showEdit($id) {
        $result = LeaveType::whereid($id)->first();
        return view('hrms.leave.add_leave_type', compact('result'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    Public function doEdit(Request $request, $id) {
        $leave_type = $request->leave_type;
        $description = $request->description;

        $edit = LeaveType::findOrFail($id);
        if (!empty($leave_type)) {
            $edit->leave_type = $leave_type;
        }
        if (!empty($description)) {
            $edit->description = $description;
        }
        $edit->save();

        \Session::flash('flash_message', 'Leave Type successfully updated!');
        return redirect('leave-type-listing');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function doDelete($id) {
        $leave = LeaveType::find($id);
        $leave->delete();
        \Session::flash('flash_message1', 'Leave Type successfully Deleted!');
        return redirect('leave-type-listing');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function doApply() {
        $leaves = LeaveType::get();
        return view('hrms.leave.apply_leave', compact('leaves'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processApply(Request $request) {
        $days = explode('days leave', $request->number_of_days);
        if (sizeof($days) < 2) {
            $days = explode('day leave', $request->number_of_days);
        }
        $number_of_days = $this->wordsToNumber($days[0]);

        $leave = new EmployeeLeaves;

        $team = Team::where('member_id', \Auth::user()->employee->id)->first();
        if ($team) {
            $tl_id = $team->leader_id;
            $manager_id = $team->manager_id;

            //$manager = Employee::where('id', $manager_id)->with('user')->first();
            // $teamLead = Employee::where('id', $tl_id)->with('user')->first();
            $leave->tl_id = $tl_id;
            $leave->manager_id = $manager_id;

            //$emails[] = ['email' => $manager->user->email, 'name' => $manager->user->name];
            //$emails[] = ['email' => $teamLead->user->email, 'name' => $teamLead->user->name];
        }

        $leave->user_id = \Auth::user()->id;
        $leave->date_from = date_format(date_create($request->dateFrom), 'Y-m-d');
        $leave->date_to = date_format(date_create($request->dateTo), 'Y-m-d');
        $leave->from_time = $request->time_from;
        $leave->to_time = $request->time_to;
        $leave->reason = $request->reason;
        $leave->days = $number_of_days;
        $leave->status = '0';
        $leave->leave_type_id = $request->leave_type;
        $leave->manager_approve = 0;
        $leave->exit_reentry_flag = $request->visa_flag;
        $leave->flight_ticket_flag = $request->ticket_flag;
        if($leave->flight_ticket_flag ==1){
            $leave->self_ticket = $request->ticket_self;
            $leave->spouse_ticket = $request->ticket_spouse;
            $leave->children_ticket = $request->ticket_children;
        }
        $leave->save();


        $leaveType = LeaveType::where('id', $request->leave_type)->first();

        $emails[] = ['email' => env('HR_EMAIL'), 'name' => env('HR_NAME')];

        $leaveDraft = LeaveDraft::where('leave_type_id', $request->leave_type)->first();

        $subject = isset($leaveDraft->subject) ? $leaveDraft->subject : '';
        $user = \Auth::user();
        $toReplace = ['%name%', '%leave_type%', '%from_date%', '%to_date%', '%days%'];
        $replaceWith = [$user->name, $leaveType->leave_type, $request->dateFrom, $request->dateTo, $number_of_days];
        $body = str_replace($toReplace, $replaceWith, '');

        //now send a mail
        /* $this->mailer->send('emails.leave_approval', ['body' => $body], function ($message) use ($emails, $user, $subject) {
          foreach ($emails as $email) {
          $message->from($user->email, $user->name);
          $message->to($email['email'], $email['name'])->subject($subject);
          }
          }); */


        \Session::flash('flash_message', 'Leave successfully applied!');
        return redirect()->back();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showMyLeave() {

        $leaves = EmployeeLeaves::with('exitReentry', 'tickets')->where('user_id', \Auth::user()->id)->paginate(15);

        return view('hrms.leave.show_my_leaves', compact('leaves'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showAllLeave() {
        if (!\Auth::user()->isHR()) {
            $leaves = EmployeeLeaves::with('user.employee')->where('tl_id', \Auth::user()->id)->orWhere('manager_id', \Auth::user()->id)->paginate(15);
        } else if (\Auth::user()->isManager()) {
            $leaves = EmployeeLeaves::with('user.employee')->where('tl_id', \Auth::user()->id)->orWhere('manager_id', \Auth::user()->id)->paginate(15);
        } else {
            $leaves = EmployeeLeaves::with('user.employee')->paginate(15);
        }

        $column = '';
        $string = '';
        $dateFrom = '';
        $dateTo = '';
        return view('hrms.leave.total_leave_request', compact('leaves', 'column', 'string', 'dateFrom', 'dateTo'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLeaveDraft() {
        $leaves = LeaveType::get();
        return view('hrms.leave.leave_draft', compact('leaves'));
    }

    /**
     * @param Requests\LeaveDraftRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createLeaveDraft(Requests\LeaveDraftRequest $request) {
        $draft = new LeaveDraft;
        $draft->subject = $request->subject;
        $draft->body = $request->body;
        $draft->leave_type_id = $request->leave_type;
        $draft->save();

        \Session::flash('flash_message', 'Leave successfully drafted!');
        return redirect()->back();
    }

    function wordsToNumber($data) {
        // Replace all number words with an equivalent numeric value
        $data = strtr(
                $data, array(
            'zero' => '0',
            'a' => '1',
            'one' => '1',
            'two' => '2',
            'three' => '3',
            'four' => '4',
            'five' => '5',
            'six' => '6',
            'seven' => '7',
            'eight' => '8',
            'nine' => '9',
            'ten' => '10',
            'eleven' => '11',
            'twelve' => '12',
            'thirteen' => '13',
            'fourteen' => '14',
            'fifteen' => '15',
            'sixteen' => '16',
            'seventeen' => '17',
            'eighteen' => '18',
            'nineteen' => '19',
            'twenty' => '20',
            'thirty' => '30',
            'forty' => '40',
            'fourty' => '40', // common misspelling
            'fifty' => '50',
            'sixty' => '60',
            'seventy' => '70',
            'eighty' => '80',
            'ninety' => '90',
            'hundred' => '100',
            'thousand' => '1000',
            'million' => '1000000',
            'billion' => '1000000000',
            'Full' => '1',
            'and' => '',
                )
        );

        // Coerce all tokens to numbers
        $parts = array_map(
                function ($val) {
            return floatval($val);
        }, preg_split('/[\s-]+/', $data)
        );

        $stack = new \SplStack(); //Current work stack
        $sum = 0; // Running total
        $last = null;

        foreach ($parts as $part) {
            if (!$stack->isEmpty()) {
                // We're part way through a phrase
                if ($stack->top() > $part) {
                    // Decreasing step, e.g. from hundreds to ones
                    if ($last >= 1000) {
                        // If we drop from more than 1000 then we've finished the phrase
                        $sum += $stack->pop();
                        // This is the first element of a new phrase
                        $stack->push($part);
                    } else {
                        // Drop down from less than 1000, just addition
                        // e.g. "seventy one" -> "70 1" -> "70 + 1"
                        $stack->push($stack->pop() + $part);
                    }
                } else {
                    // Increasing step, e.g ones to hundreds
                    $stack->push($stack->pop() * $part);
                }
            } else {
                // This is the first element of a new phrase
                $stack->push($part);
            }

            // Store the last processed part
            $last = $part;
        }

        return $sum + $stack->pop();
    }

    public function searchLeave(Request $request) {
        try {
            $string = $request->string;
            if ($string == 'Approved' || $string == 'approved') {
                $string = 1;
            } elseif ($string == 'Pending' || $string == 'pending') {
                $string = 0;
            } elseif ($string == 'Disapproved' || $string == 'disapproved') {
                $string = 2;
            }

            $column = $request->column;
            $dateTo = $request->dateTo;
            $dateFrom = $request->dateFrom;

            $data = ['name' => 'users.name', 'code' => 'employees.code', 'days' => 'employee_leaves.days', 'leave_type' => 'leave_types.leave_type', 'status' => 'employee_leaves.status'];

            if ($request->button == 'Search') {
                /**
                 * First we build a query string which is common in both cases whether we have a condition set or not
                 */
                $leaves = \DB::table('users')->select(
                                'users.id', 'users.name', 'employees.code', 'employee_leaves.days', 'employee_leaves.date_from', 'employee_leaves.date_to', 'employee_leaves.status', 'leave_types.leave_type', 'employee_leaves.remarks', 'employee_leaves.manager_approve')
                        ->join('employees', 'employees.user_id', '=', 'users.id')
                        ->join('employee_leaves', 'employee_leaves.user_id', '=', 'users.id')
                        ->join('leave_types', 'leave_types.id', '=', 'employee_leaves.leave_type_id');

                if (!empty($column) && !empty($string) && empty($dateFrom) && empty($dateTo)) {
                    $leaves = $leaves->whereRaw($data[$column] . " like '%" . $string . "%' ")->paginate(20);
                } elseif (!empty($dateFrom) && !empty($dateTo) && empty($column) && empty($string)) {
                    $dateTo = date_format(date_create($request->dateTo), 'Y-m-d');
                    $dateFrom = date_format(date_create($request->dateFrom), 'Y-m-d');
                    $leaves = $leaves->whereBetween('date_from', [$dateFrom, $dateTo])->paginate(20);
                } elseif (!empty($column) && !empty($string) && !empty($dateFrom) && !empty($dateTo)) {
                    $dateTo = date_format(date_create($request->dateTo), 'Y-m-d');
                    $dateFrom = date_format(date_create($request->dateFrom), 'Y-m-d');
                    $leaves = $leaves->whereRaw($data[$column] . " like '%" . $string . "%'")->whereBetween('date_from', [$dateFrom, $dateTo])->paginate(20);
                } else {
                    $leaves = $leaves->paginate(20);
                }
                $post = 'post';

                return view('hrms.leave.total_leave_request', compact('leaves', 'post', 'column', 'string', 'dateFrom', 'dateTo'));
            } else {
                /**
                 * First we build a query string which is common in both cases whether we have a condition set or not
                 */
                $leaves = \DB::table('users')->select('users.id', 'users.name', 'employees.code', 'employee_leaves.days', 'employee_leaves.date_from', 'employee_leaves.date_to', 'employee_leaves.status', 'leave_types.leave_type', 'employee_leaves.remarks')->join('employees', 'employees.user_id', '=', 'users.id')->join('employee_leaves', 'employee_leaves.user_id', '=', 'users.id')->join('leave_types', 'leave_types.id', '=', 'employee_leaves.leave_type_id');

                if (!empty($column) && !empty($string) && empty($dateFrom) && empty($dateTo)) {
                    $leaves = $leaves->whereRaw($data[$column] . " like '%" . $string . "%' ")->get();
                } elseif (!empty($dateFrom) && !empty($dateTo) && empty($column) && empty($string)) {
                    $dateTo = date_format(date_create($request->dateTo), 'Y-m-d');
                    $dateFrom = date_format(date_create($request->dateFrom), 'Y-m-d');
                    $leaves = $leaves->whereBetween('date_from', [$dateFrom, $dateTo])->get();
                } elseif (!empty($column) && !empty($string) && !empty($dateFrom) && !empty($dateTo)) {
                    $dateTo = date_format(date_create($request->dateTo), 'Y-m-d');
                    $dateFrom = date_format(date_create($request->dateFrom), 'Y-m-d');
                    $leaves = $leaves->whereRaw($data[$column] . " like '%" . $string . "%'")->whereBetween('date_from', [$dateFrom, $dateTo])->get();
                } else {
                    $leaves = $leaves->get();
                }
                /* $leaves = $leaves->get(); */

                $fileName = 'Leave_Listing_' . rand(1, 1000) . '.xlsx';
                $filePath = storage_path('export/') . $fileName;
                $file = new \SplFileObject($filePath, "a");
                // Add header to csv file.
                $headers = ['id', 'name', 'code', 'leave_type', 'date_from', 'date_to', 'days', 'status', 'remarks', 'created_at', 'updated_at'];
                $file->fputcsv($headers);
                $status = '';
                foreach ($leaves as $leave) {
                    if ($leave->status == 0) {
                        $status = 'Pending';
                    } elseif ($leave->status == 1) {
                        $status = 'Approved';
                    } elseif ($leave->status == 2) {
                        $status = 'Disapproved';
                    }
                    $file->fputcsv([$leave->id, $leave->name, $leave->code, $leave->leave_type, $leave->date_from, $leave->date_to, $leave->days, $status, $leave->remarks]);
                }

                return response()->download(storage_path('exports/') . $fileName);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    public function exportData($request) {
        
    }

    public function getLeaveCount(Request $request) {
        $leaveTypeId = $request->leaveTypeId;
        $userId = $request->userId;
        $leaveEndDate = date('Y-m-d',strtotime($request->leaveEnd));

        $count = EmployeeLeaves::where(['user_id' => $userId, 'leave_type_id' => $leaveTypeId, 'status' => '1'])->get();
        $day = 0;
        foreach ($count as $days) {
            $day += $days->days;
        }
        //calculate total leaves
        $yearlyLeaves = totalLeaves($leaveTypeId);
        $daydifference = Employee::where('user_id', $userId)->select(\DB::raw('DATEDIFF("'.$leaveEndDate.'",date_of_joining) as datediff'))->first();
        $totalDays = $daydifference->datediff;
        $totalLeaves = $totalDays * ($yearlyLeaves/365); 
        if($totalLeaves > 60) {
          $totalLeaves =60;   
        }
        $remainingLeaves = $totalLeaves - $day;
        return json_encode($remainingLeaves);
    }

    /**
     * @param Request $request
     *
     * @return string
     */
    public function approveLeave(Request $request) {
        $leaveId = $request->leaveId;
        $remarks = $request->remarks;
        $approvedBy = $request->approvedBy;
        $exitReentry = $request->exitFlag;
        $period = $request->exitPeriod;
        $employeeLeave = EmployeeLeaves::where('id', $leaveId)->first();
        $user = User::where('id', $employeeLeave->user_id)->first();
        $this->mailer->send('emails.leave_status', ['user' => $user, 'status' => 'approved', 'remarks' => $remarks, 'leave' => $employeeLeave], function($message) use($user) {
            $message->from('no-reply@dipi-ip.com', 'Digital IP Insights');
            $message->to($user->email, $user->name)->subject('Your leave has been approved');
        });

        if ($approvedBy == 1) {
            \DB::table('employee_leaves')->where('id', $leaveId)->update(['manager_approve' => '1', 'remarks' => $remarks]);
        } else {
            \DB::table('employee_leaves')->where('id', $leaveId)->update(['status' => '1', 'remarks' => $remarks]);
        }
        $flag = false;
        if ($request->ticket_approve == 1 && $approvedBy == 2) {
            //insert ticket log  
//             $insertArray = array("user_id" => $employeeLeave->user_id,
//                "leave_id" => $leaveId, 
//                "created_date" => date('Y-m-d'),
//            
//        );
//        $insertId = \DB::table('ticket_log')->insertGetId($insertArray);
            $flag = true;
        }

        if ($exitReentry == 1 && $approvedBy == 2) {
            $flag = true;
            //Exit reentry 
            $insertArray = array("leave_id" => $leaveId,
                "created_date" => date('Y-m-d H:i'),
                'updated_date' => date('Y-m-d H:i'),
                "period" => $period,
                "visa_amount" => ($period / 30) * 100
            );

            \DB::table('exit_reentry_details')->insertGetId($insertArray);
        }
        if ($flag) {
            //entry to travel expense table
            
            $insertArray = array("leave_id" => $leaveId,
                "created_date" => date('Y-m-d'),
                "self_ticket" =>1,
                "spouse_ticket" =>$employeeLeave->spouse_ticket,
                "children_ticket" =>$employeeLeave->children_ticket,
                
            );
            $insertId = \DB::table('travel_expense')->insertGetId($insertArray);
        }

        return json_encode('success');
    }

    /**
     * @param Request $request
     *
     * @return string
     */
    public function disapproveLeave(Request $request) {
        $leaveId = $request->leaveId;
        $remarks = $request->remarks;
        $approvedBy = $request->approvedBy;
        $employeeLeave = EmployeeLeaves::where('id', $leaveId)->first();
        $user = User::where('id', $employeeLeave->user_id)->first();
        $this->mailer->send('emails.leave_status', ['user' => $user, 'status' => 'disapproved', 'remarks' => $remarks, 'leave' => $employeeLeave], function($message) use($user) {
            $message->from('no-reply@dipi-ip.com', 'Digital IP Insights');
            $message->to($user->email, $user->name)->subject('Your leave has been disapproved');
        });
        if ($approvedBy == 1) {
            \DB::table('employee_leaves')->where('id', $leaveId)->update(['manager_approve' => '2', 'remarks' => $remarks]);
        } else {
            \DB::table('employee_leaves')->where('id', $leaveId)->update(['status' => '2', 'remarks' => $remarks]);
        }



        return json_encode('success');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showHolidays() {
        $holidays = Holiday::paginate(10);
        $filenames = HolidayFilenames::get();
        return view('hrms.leave.holiday', compact('holidays', 'filenames'));
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processHolidays(Request $request) {
        try {
            if (Input::hasFile('upload_file')) {
                $file = Input::file('upload_file');
                $allowedext = ["xlsx", "xls"];
                $extension = $file->getClientOriginalExtension();
                $filename = $file->getClientOriginalName();


                if (in_array($extension, $allowedext)) {

                    //move this file to storage path
                    $file->move(storage_path('holidays/'), $filename);
                    $holiday = new HolidayFilenames();
                    $holiday->name = $filename;
                    $holiday->description = $request->description;
                    $holiday->date = date_format(date_create($request->date), 'Y-m-d');
                    $holiday->save();
                } else {
                    \Session::flash('flash_message', 'Please upload only excel files with xls or xlsx extension');

                    return redirect()->back();
                }

                Excel::load(storage_path('holidays/' . $filename), function ($reader) {
                    $rows = $reader->get(['occasion', 'date_from', 'date_to']);

                    foreach ($rows as $row) {
                        $holiday = new Holiday();
                        $holiday->occasion = $row->occasion;
                        $holiday->date_from = $row->date_from;
                        $holiday->date_to = $row->date_to;
                        $holiday->save();
                    }
                    return redirect()->back()->with('flash_message', 'Holidays successfully added');
                });
            }
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            \Log::info($e->getLine());
            return redirect()->back()->with('flash_message', $e->getMessage());
        }
    }

    public function showHoliday() {

        $holidays = Holiday::paginate(10);
        return view('hrms.leave.show_holiday', compact('holidays'));
    }

    public function showEditHoliday($id) {
        $holidays = Holiday::where('id', $id)->first();
        return view('hrms.leave.edit_holiday', compact('holidays'));
    }

    public function doEditHoliday($id, Request $request) {
        $holiday = Holiday::where('id', $id)->first();
        $holiday->occasion = $request->occasion;
        $holiday->date_from = date_format(date_create($request->date_from), 'Y-m-d');
        $holiday->date_from = date_format(date_create($request->date_from), 'Y-m-d');
        $holiday->save();

        \Session::flash('flash_message', 'Holiday successfully updated!');
        return redirect('holiday-listing');
    }

    public function deleteHoliday($id) {
        $holiday = Holiday::find($id);
        $holiday->delete();

        \Session::flash('flash_message', 'Holiday successfully deleted!');
        return redirect('holiday-listing');
    }

    //Leave expense listing

    public function listAllLeaveexpense() {

        $expenses = \DB::table('employee_leaves')->select(
                                'users.id', 'users.name', 'employees.user_id as employeeId', 'employees.code', 'employee_leaves.date_from', 'employee_leaves.date_to', 'travel_expense.approved_status', 'employees.name', 'employee_leaves.leave_type_id', 'travel_expense.id as expId', 'travel_expense.remarks', 'travel_expense.leave_id as leaveId', 'travel_expense.ticket_file','employees.id as applieduser','employee_leaves.self_ticket','employee_leaves.spouse_ticket','employee_leaves.children_ticket')
                        ->join('employees', 'employees.user_id', '=', 'employee_leaves.user_id')
                        ->join('users', 'employees.user_id', '=', 'users.id')
                        ->join('travel_expense', 'travel_expense.leave_id', '=', 'employee_leaves.id')->paginate(15);

        return view('hrms.leave.leave_expense_request', compact('expenses'));
    }

    /**
     * @param Request $request
     *
     * @return string
     */
    public function approveExpense(Request $request) {
        $expenseId = $request->get('request_id');
        $remarks = $request->get('remarks');
        $leaveId = $request->get('leavereq_id');
        $updateArray = array('approved_status' => '1', 'remarks' => $remarks);
        if (Input::hasFile('upload_file')) {
            $file = Input::file('upload_file');
            $extension = $file->getClientOriginalExtension();
            $filename = $file->getClientOriginalName();
            $file->move(storage_path('Leavedocuments/' . $leaveId), $filename);
            $updateArray['ticket_file'] = $filename;
        }





        \DB::table('travel_expense')->where('id', $expenseId)->update($updateArray);
        //Insert ticket accepted log
        $employeeLeave = EmployeeLeaves::where('id', $leaveId)->first();
        $insertArray = array("user_id" => $employeeLeave->user_id,
            "leave_id" => $leaveId,
            "created_date" => date('Y-m-d'),
        );
        
        $insertId = \DB::table('ticket_log')->insertGetId($insertArray);
        
        //update ticket details
        
        $selfTicket = $request->get('ticket_self',0);
        $spouceTicket = $request->get('ticket_spouse',0);
        $childTicket = $request->get('ticket_children',0);
        
        $userDetail = User::with('employee')->where('id',$employeeLeave->user_id)->first();
        $availableTicketDetails = \DB::table('employee_current_year_ticket')->where('employee_id',$userDetail->employee->id)->whereYear('period_from','=',date('Y', strtotime($employeeLeave->date_from)))->select('self_ticket_taken as selfticketCount','spouce_ticket_taken as spouceticketCount','children_ticket_taken as childticketCount','self_ticket_count','spouce_ticket_count','children_ticket_count')->first();
        
        
        $updateArray = array("self_ticket_taken" => $availableTicketDetails->selfticketCount+$selfTicket,
            "spouce_ticket_taken" => $availableTicketDetails->spouceticketCount+$spouceTicket,
            "children_ticket_taken" => $availableTicketDetails->childticketCount+$childTicket             
        );

        \DB::table('employee_current_year_ticket')->where('employee_id',$userDetail->employee->id)-> where('period_from','>=',date('Y-m-d', strtotime($employeeLeave->date_from)))->where('period_to','<=',date('Y-m-d', strtotime($employeeLeave->date_from)))->update($updateArray);

        \Session::flash('flash_message', 'Successfully approve the ticket request');
        return redirect('travel-expense');
    }

    /**
     * @param Request $request
     *
     * @return string
     */
    public function disapproveExpense(Request $request) {

        $expenseId = $request->expId;
        $remarks = $request->remarks;
        \DB::table('travel_expense')->where('id', $expenseId)->update(['approved_status' => '2', 'remarks' => $remarks]);

        return json_encode('success');
    }
/**
 * 
 * @param type $id
 * @return type
 */
    public function listTraveldetails($id) {

        $leaves = \DB::table('ticket_log')->select(
                        'users.id', 'users.name', 'employees.code', 'employee_leaves.days', 'employee_leaves.date_from', 'employee_leaves.date_to', 'leave_types.leave_type', 'employee_leaves.remarks', 'employee_leaves.exit_reentry_flag', 'employee_leaves.flight_ticket_flag', 'employee_leaves.leave_type_id')
                ->join('employee_leaves', function ($join) {
                    $join->on('employee_leaves.id', '=', 'ticket_log.leave_id')
                    ->where('employee_leaves.leave_type_id', '=', 1)
                    ->where('employee_leaves.status', '=', 1);
                })
                ->join('travel_expense', 'travel_expense.leave_id', '=', 'employee_leaves.id')
                ->join('users', 'ticket_log.user_id', '=', 'users.id')
                ->join('employees', 'employees.user_id', '=', 'users.id')
                ->join('leave_types', 'leave_types.id', '=', 'employee_leaves.leave_type_id')
                ->where('ticket_log.user_id', $id)
                ->where('travel_expense.approved_status', '=', 1)
                ->get();

        return view('hrms.leave.leave_ticket_details', compact('leaves'));
    }
/**
 * 
 * @return type
 */
    public function exitreentryList() {
        $exitreentrylists = \DB::table('employee_leaves')->select(
                                'users.id', 'users.name', 'employees.user_id as employeeId', 'employees.code', 'employee_leaves.date_from', 'exit_reentry_details.created_date', 'exit_reentry_details.updated_date', 'exit_reentry_details.approve_status', 'employees.name', 'exit_reentry_details.request_status', 'exit_reentry_details.id as expId', 'exit_reentry_details.visa_amount', 'exit_reentry_details.period', 'exit_reentry_details.leave_id as leaveId', 'exit_reentry_details.uploaded_file')
                        ->join('employees', 'employees.user_id', '=', 'employee_leaves.user_id')
                        ->join('users', 'employees.user_id', '=', 'users.id')
                        ->join('exit_reentry_details', 'exit_reentry_details.leave_id', '=', 'employee_leaves.id')->paginate(15);

        $column = '';
        $string = '';
        $dateFrom = '';
        $dateTo = '';
        return view('hrms.leave.exit_reentry_request', compact('exitreentrylists', 'column', 'string', 'dateFrom', 'dateTo'));
    }
/**
 * 
 * @param Request $request
 * @return type
 */
    public function searchExitRenetry(Request $request) {
        try {
            $string = $request->string;


            $column = $request->column;
            $dateTo = $request->dateTo;
            $dateFrom = $request->dateFrom;

            $data = ['name' => 'users.name', 'code' => 'employees.code'];
            $requestArray = [];

            if ($request->button == 'Search') {
                /**
                 * First we build a query string which is common in both cases whether we have a condition set or not
                 */
                $exitreentrylists = \DB::table('employee_leaves')->select(
                                'users.id', 'users.name', 'employees.user_id as employeeId', 'employees.code', 'employee_leaves.date_from', 'exit_reentry_details.created_date', 'exit_reentry_details.updated_date', 'exit_reentry_details.approve_status', 'employees.name', 'exit_reentry_details.request_status', 'exit_reentry_details.id as expId', 'exit_reentry_details.visa_amount', 'exit_reentry_details.period', 'exit_reentry_details.leave_id as leaveId', 'exit_reentry_details.uploaded_file')
                        ->join('employees', 'employees.user_id', '=', 'employee_leaves.user_id')
                        ->join('users', 'employees.user_id', '=', 'users.id')
                        ->join('exit_reentry_details', 'exit_reentry_details.leave_id', '=', 'employee_leaves.id');




                if (!empty($column) && !empty($string) && empty($dateFrom) && empty($dateTo)) {
                    $exitreentrylists = $exitreentrylists->whereRaw($data[$column] . " like '%" . $string . "%' ")->paginate(20);
                } elseif (!empty($dateFrom) && !empty($dateTo) && empty($column) && empty($string)) {
                    $exitreentrylists = $exitreentrylists->whereBetween('exit_reentry_details.created_date', [$dateFrom, $dateTo])->paginate(20);
                } elseif (!empty($column) && !empty($string) && !empty($dateFrom) && !empty($dateTo)) {
                    $dateTo = date_format(date_create($request->dateTo), 'Y-m-d');
                    $dateFrom = date_format(date_create($request->dateFrom), 'Y-m-d');
                    $exitreentrylists = $exitreentrylists->whereRaw($data[$column] . " like '%" . $string . "%'")->whereBetween('exit_reentry_details.created_date', [$dateFrom, $dateTo])->paginate(20);
                } else {
                    $exitreentrylists = $exitreentrylists->paginate(20);
                }

                $post = 'post';

                return view('hrms.leave.exit_reentry_request', compact('exitreentrylists', 'post', 'column', 'string', 'dateFrom', 'dateTo'));
            } else {


                /**
                 * First we build a query string which is common in both cases whether we have a condition set or not
                 */
                $exitreentrylists = \DB::table('employee_leaves')->select(
                                'users.id', 'users.name', 'employees.user_id as employeeId', 'employees.code', 'employee_leaves.date_from', 'exit_reentry_details.created_date', 'exit_reentry_details.updated_date', 'exit_reentry_details.approve_status', 'employees.name', 'exit_reentry_details.request_status', 'exit_reentry_details.id as expId', 'exit_reentry_details.visa_amount', 'exit_reentry_details.period', 'exit_reentry_details.leave_id as leaveId', 'exit_reentry_details.uploaded_file',\DB::raw("(case exit_reentry_details.request_status when 0 then 'Open' when 1 then 'Completed'   end) AS statusString"))
                        ->join('employees', 'employees.user_id', '=', 'employee_leaves.user_id')
                        ->join('users', 'employees.user_id', '=', 'users.id')
                        ->join('exit_reentry_details', 'exit_reentry_details.leave_id', '=', 'employee_leaves.id');




             if (!empty($column) && !empty($string) && empty($dateFrom) && empty($dateTo)) {
                    $exitreentrylists = $exitreentrylists->whereRaw($data[$column] . " like '%" . $string . "%' ")->get();
                } elseif (!empty($dateFrom) && !empty($dateTo) && empty($column) && empty($string)) {
                    $exitreentrylists = $exitreentrylists->whereBetween('exit_reentry_details.created_date', [$dateFrom, $dateTo])->get();
                } elseif (!empty($column) && !empty($string) && !empty($dateFrom) && !empty($dateTo)) {
                    $dateTo = date_format(date_create($request->dateTo), 'Y-m-d');
                    $dateFrom = date_format(date_create($request->dateFrom), 'Y-m-d');
                    $exitreentrylists = $exitreentrylists->whereRaw($data[$column] . " like '%" . $string . "%'")->whereBetween('exit_reentry_details.created_date', [$dateFrom, $dateTo])->get();
                } else {
                    $exitreentrylists = $exitreentrylists->get();
                }




                $requestArray[] = ['id', 'Name', 'Code', 'Visa amount', 'Visa period', 'Leave start date', 'Created date', 'Request status'];

                foreach ($exitreentrylists as $key => $exitreentry) {

                   

                    $requestArray [] = array(
                        'Id' => $key + 1,
                        'Name' => $exitreentry->name,
                        'Code' => $exitreentry->code,
                        'Visa amount' => number_format($exitreentry->visa_amount, 2),
                        'Visa period' => $exitreentry->period,
                        'Leave start date' => date('d-m-Y', strtotime($exitreentry->date_from)),
                        'Created date' => date('d-m-Y', strtotime($exitreentry->created_date)),
                        'Request status' => $exitreentry->statusString
                        
                    );
                }


                Excel::create('Exitrenetry_List_' . date('Ymdhis'), function($excel) use ($requestArray) {
                    $excel->setTitle('Employees exit re-entry details');
                    $excel->sheet('Visa', function($sheet) use ($requestArray) {
                        $sheet->fromArray($requestArray, null, 'A1', false, false);
                        $sheet->setPageMargin(array(
                            0.25, 0.30, 0.25, 0.30
                        ));
                        $sheet->row(1, function($row) {
                            // call cell manipulation methods
                            $row->setBackground('#4F5467');
                            $row->setFontColor('#ffffff');
                            $row->setFontSize(16);
                            $row->setFontWeight('bold');
                        });
                    });
                })->download('xlsx');
            }
        } catch (\Exception $e) {

            return redirect()->back()->with('message', $e->getMessage());
        }
    }
/**
 * 
 * @param Request $request
 * @return type
 */
    public function changeStatus(Request $request) {
        $leaveId = $request->leaveId;
        $requestId = $request->reqId;
        $status = $request->status;
        \DB::table('exit_reentry_details')->where('id', $requestId)->where('leave_id', $leaveId)->update(['approve_status' => $status, 'updated_date' => date('Y-m-d H:i')]);
        return json_encode('success');
    }
/**
 * 
 * @param Request $request
 * @return type
 */
    public function closevisaRequest(Request $request) {
        $leaveId = $request->get('leavereq_id');
        $requestId = $request->get('r_id');
        $updateArray = array('request_status' => 1, 'updated_date' => date('Y-m-d H:i'));

        if (Input::hasFile('upload_file')) {
            $file = Input::file('upload_file');
            $extension = $file->getClientOriginalExtension();
            $filename = $file->getClientOriginalName();
            $file->move(storage_path('Leavedocuments/' . $leaveId), $filename);
            $updateArray['uploaded_file'] = $filename;
        }
        \DB::table('exit_reentry_details')->where('id', $requestId)->where('leave_id', $leaveId)->update($updateArray);

        \Session::flash('flash_message', 'Successfully closed the request');
        return redirect('exit-entry-list');
    }
    
   public function showLeaveDetails($leaveId){
    $leave = EmployeeLeaves::with('user.employee')->where('id', $leaveId)->first();

        return view('hrms.leave.leave_overview', compact('leave'));  
   }

}
