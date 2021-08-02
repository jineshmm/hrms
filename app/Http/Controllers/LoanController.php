<?php

namespace App\Http\Controllers;

use App\EmployeeLoans;

use App\Models\Employee;
use App\Models\Holiday;

use App\Models\LeaveType;
use App\Models\LoanType;
use App\Models\Team;
use App\User;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;

class LoanController extends Controller {

    /**
     * LeaveController constructor.
     * @param Mailer $mailer
     */
    public function __construct(Mailer $mailer) {
        $this->mailer = $mailer;
    }


   
    public function doApply() {
       $loanTypes = LoanType::get();
     
        return view('hrms.loan.apply_loan', compact('loanTypes','employee'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processApply(Request $request) {
        

        $loan = new EmployeeLoans;

        $team = Team::where('member_id', \Auth::user()->employee->id)->first();
        if ($team) {
            $manager_id = $team->manager_id;
            $manager = Employee::where('id', $manager_id)->with('user')->first();
            $loan->manager_id = $manager_id;
            //$emails[] = ['email' => $manager->user->email, 'name' => $manager->user->name];           
        }

        $loan->user_id = \Auth::user()->id;       
        $loan->reason = $request->reason;
        $loan->amount = $request->amount;
        $loan->applied_to = date_format(date_create($request->dateFrom), 'Y-m-d');
        $loan->loan_type_id = $request->loan_type;
        $loan->installment_number = $request->installment_number;

        $loan->save();


        


        \Session::flash('flash_message', 'Successfully added loan request!!!');
        return redirect()->back();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showMyLoans() {

        $loans = EmployeeLoans::where('user_id', \Auth::user()->id)->paginate(15);
             
         return view('hrms.loan.show_my_loans', compact('loans'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showAllLoan() {
        if (!\Auth::user()->isHR()) {
            $loans = EmployeeLoans::with('user.employee')->where('manager_id', \Auth::user()->id)->paginate(15);
        } else if (\Auth::user()->isManager()) {
            $loans = EmployeeLoans::with('user.employee')->where('manager_id', \Auth::user()->id)->paginate(15);
        } else {
            $loans = EmployeeLoans::with('user.employee')->paginate(15);
        }

        $column = '';
        $string = '';
        $dateFrom = '';
        $dateTo = '';
        return view('hrms.loan.total_loan_request', compact('loans', 'column', 'string', 'dateFrom', 'dateTo'));
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

    public function searchLoan(Request $request) {
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
            $data = ['name' => 'users.name'];
            if ($request->button == 'Search') {
                /**
                 * First we build a query string which is common in both cases whether we have a condition set or not
                 */
                $loans = \DB::table('users')->select(
                                'users.id', 'users.name', 'employees.code', 'employee_loans.amount', 'employee_loans.manager_approve_status', 'employee_loans.finance_approve_status', 'employee_loans.reason', 'employee_loans.manager_id', 'employee_loans.created_at')
                        ->join('employees', 'employees.user_id', '=', 'users.id')
                        ->join('employee_loans', 'employee_loans.user_id', '=', 'users.id');
                        
                if (!empty($column) && !empty($string) ) {         
                    $loans = $loans->whereRaw($data[$column] . " like '%" . $string . "%' ")->paginate(20);
                } else {
                    $loans = $loans->paginate(20);
                }
                $post = 'post';
             
                return view('hrms.loan.total_loan_request', compact('loans', 'post', 'column', 'string'));
            } else {
                
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    public function exportData($request) {
        
    }

   

    /**
     * @param Request $request
     *
     * @return string
     */
    public function approveLoan(Request $request) {
        $loanId = $request->loanId;
        $remarks = $request->remarks;
        $approvedBy = $request->approvedBy;
        $employeeLoan = EmployeeLoans::where('id', $loanId)->first();
        $user = User::where('id', $employeeLoan->user_id)->first();
//        $this->mailer->send('emails.leave_status', ['user' => $user, 'status' => 'approved', 'remarks' => $remarks, 'leave' => $employeeLeave], function($message) use($user) {
//            $message->from('no-reply@dipi-ip.com', 'Digital IP Insights');
//            $message->to($user->email, $user->name)->subject('Your leave has been approved');
//        });

        if ($approvedBy == 1) {
            \DB::table('employee_loans')->where('id', $loanId)->update(['manager_approve_status' => '1', 'reason' => $remarks]);
        } else {
            \DB::table('employee_loans')->where('id', $loanId)->update(['finance_approve_status' => '1', 'reason' => $remarks]);
            //create installment detail of each month
            $this->installmentCreation($loanId);
            
        }

        return json_encode('success');
    }

    /**
     * @param Request $request
     *
     * @return string
     */
    public function disapproveLoan(Request $request) {
        $loanId = $request->loanId;
        $remarks = $request->remarks;
        $approvedBy = $request->approvedBy;
        $employeeLoan = EmployeeLoans::where('id', $loanId)->first();
        $user = User::where('id', $employeeLoan->user_id)->first();
//        $this->mailer->send('emails.leave_status', ['user' => $user, 'status' => 'disapproved', 'remarks' => $remarks, 'leave' => $employeeLeave], function($message) use($user) {
//            $message->from('no-reply@dipi-ip.com', 'Digital IP Insights');
//            $message->to($user->email, $user->name)->subject('Your leave has been disapproved');
//        });
         if ($approvedBy == 1) {
            \DB::table('employee_loans')->where('id', $loanId)->update(['manager_approve_status' => '2', 'reason' => $remarks]);
        } else {
            \DB::table('employee_loans')->where('id', $loanId)->update(['finance_approve_status' => '2', 'reason' => $remarks]);
        }
       
        return json_encode('success');
    }
    
    private function installmentCreation($loanId) {
       $employeeLoan = EmployeeLoans::where('id', $loanId)->first();  
        $installmentArray =[];     
       $installmentAmount = $employeeLoan->amount/$employeeLoan->installment_number;
      
       for($i=1; $i <= $employeeLoan->installment_number;$i++) {
         $installmentArray[$i]= array('loan_id' =>$loanId,
                                        'user_id' =>$employeeLoan->user_id,
                                        'amount'=>$installmentAmount,
                                        'installment_date'=>date('Y-m-d', strtotime("+$i months", strtotime($employeeLoan->applied_to))));  
       }
       if(count($installmentArray)>0) {
                    
            \DB::table('loan_installment')->insert($installmentArray);
           
       }
    }
    
    public function showInstallments($id) {
        $results =  \DB::table('loan_installment')->select('*')->where('loan_id', $id)->paginate(20);
        return view('hrms.loan.installment-details', compact('results'));   
    }
    
    public function installmentActions(Request $request) {
        $installmentId = $request->instId;
     
        $remarks = $request->remarks;
        $type = $request->paidType;
        
        \DB::table('loan_installment')->where('id', $installmentId)->update(['paid_status' => $type, 'remarks' => $remarks,'updated_date' =>date('Y-m-d h:i')]);
        
        return json_encode('success');
    }
    
    public function skipInstallment(Request $request) {
        $installmentId = $request->instId;
        $loanId = $request->loanId;
           
        \DB::table('loan_installment')->where('id', $installmentId)->update(['skip_status' => 1,'updated_date' =>date('Y-m-d h:i')]);
        // create new installment shedule with new date
        $installmentDetails = \DB::table('loan_installment')->select('installment_date','amount','user_id')->where('loan_id',$loanId)->where('skip_status',0)->orderBy('id','desc')->first();
         \DB::table('loan_installment')->insert(array('loan_id' =>$loanId,
                                        'user_id' =>$installmentDetails->user_id,
                                        'amount'=>$installmentDetails->amount,
                                        'installment_date'=>date('Y-m-d', strtotime("+1 months", strtotime($installmentDetails->installment_date))),'updated_date' =>date('Y-m-d h:i') ));
        return json_encode('success');
    }
    

    


}
