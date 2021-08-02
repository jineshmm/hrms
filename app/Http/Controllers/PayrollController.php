<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PayrollController extends Controller {

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
    public function showPayrolls() {
        $column = '';
        $string = '';
        $dateFrom = '';
        $dateTo = '';
        $payrolls = \DB::table('employee_payroll')->select(
                                'users.id', 'users.name', 'employees.user_id as employeeId', 'employees.code', 'employees.name', 'employee_payroll.salary', 'employee_payroll.loan_deduction', 'employee_payroll.leave_deduction', 'employee_payroll.salary_month', 'employee_payroll.salary_year', 'employee_payroll.net_salary')
                        ->join('employees', 'employees.user_id', '=', 'employee_payroll.user_id')
                        ->join('users', 'employees.user_id', '=', 'users.id')
                        ->where('employee_payroll.salary_month', '=', date('m'))
                        ->where('employee_payroll.salary_year', '=', date('Y'))->orderBy('employee_payroll.created_date', 'desc')->paginate(20);

        return view('hrms.payroll.show_payroll_list', compact('payrolls', 'column', 'string', 'dateFrom', 'dateTo'));
    }

    /**
     * 
     * @param type $data
     * @return type
     */
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

    /**
     * 
     * @param Request $request
     * @return type
     */
    public function searchPayrolldetails(Request $request) {
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
                $payrolls = \DB::table('employee_payroll')->select(
                                'users.id', 'users.name', 'employees.user_id as employeeId', 'employees.code', 'employees.name', 'employee_payroll.salary', 'employee_payroll.loan_deduction', 'employee_payroll.leave_deduction', 'employee_payroll.salary_month', 'employee_payroll.salary_year', 'employee_payroll.net_salary')
                        ->join('employees', 'employees.user_id', '=', 'employee_payroll.user_id')
                        ->join('users', 'employees.user_id', '=', 'users.id');




                if (!empty($column) && !empty($string) && empty($dateFrom) && empty($dateTo)) {
                    $payrolls = $payrolls->whereRaw($data[$column] . " like '%" . $string . "%' ")->paginate(20);
                } elseif (!empty($dateFrom) && !empty($dateTo) && empty($column) && empty($string)) {
                    $payrolls = $payrolls->where('employee_payroll.salary_month', $dateFrom)->where('employee_payroll.salary_year', $dateTo)->paginate(20);
                } elseif (!empty($column) && !empty($string) && !empty($dateFrom) && !empty($dateTo)) {
                    $dateTo = date_format(date_create($request->dateTo), 'Y-m-d');
                    $dateFrom = date_format(date_create($request->dateFrom), 'Y-m-d');
                    $payrolls = $payrolls->whereRaw($data[$column] . " like '%" . $string . "%'")->where('employee_payroll.salary_month', $dateFrom)->where('employee_payroll.salary_year', $dateTo)->paginate(20);
                } else {
                    $payrolls = $payrolls->where('employee_payroll.salary_month', '=', date('m'))
                                    ->where('employee_payroll.salary_year', '=', date('Y'))->paginate(20);
                }

                $post = 'post';

                return view('hrms.payroll.show_payroll_list', compact('payrolls', 'post', 'column', 'string', 'dateFrom', 'dateTo'));
            } else {


                /**
                 * First we build a query string which is common in both cases whether we have a condition set or not
                 */
                $payrolls = \DB::table('employee_payroll')->select(
                                        'users.id', 'users.name', 'employees.user_id as employeeId', 'employees.code', 'employees.name', 'employee_payroll.salary', 'employee_payroll.loan_deduction', 'employee_payroll.leave_deduction', 'employee_payroll.salary_month', 'employee_payroll.salary_year', 'employee_payroll.salary as Basicsalary', 'employee_payroll.hra', 'employee_payroll.travel_allowance', 'employee_payroll.net_salary', 'employee_payroll.paid_leave_count', 'employee_payroll.gosi')
                                ->join('employees', 'employees.user_id', '=', 'employee_payroll.user_id')
                                ->join('users', 'employees.user_id', '=', 'users.id')->where('employees.status', 0);




                if (!empty($column) && !empty($string) && empty($dateFrom) && empty($dateTo)) {
                    $payrolls = $payrolls->whereRaw($data[$column] . " like '%" . $string . "%' ")->get();
                } elseif (!empty($dateFrom) && !empty($dateTo) && empty($column) && empty($string)) {
                    $payrolls = $payrolls->where('employee_payroll.salary_month', $dateFrom)->where('employee_payroll.salary_year', $dateTo)->get();
                } elseif (!empty($column) && !empty($string) && !empty($dateFrom) && !empty($dateTo)) {
                    $dateTo = date_format(date_create($request->dateTo), 'Y-m-d');
                    $dateFrom = date_format(date_create($request->dateFrom), 'Y-m-d');
                    $payrolls = $payrolls->whereRaw($data[$column] . " like '%" . $string . "%'")->where('employee_payroll.salary_month', $dateFrom)->where('employee_payroll.salary_year', $dateTo)->get();
                } else {
                    $payrolls = $payrolls->where('employee_payroll.salary_month', '=', date('m'))
                                    ->where('employee_payroll.salary_year', '=', date('Y'))->get();
                }




                $requestArray[] = ['id', 'Name', 'Code', 'Basic Salary', 'HRA', 'TA', 'Loan deduction', 'Leave deduction', 'Paid leave count', 'Gosi', 'Net salary', 'Month', 'Year'];

                foreach ($payrolls as $key => $payroll) {

                    $dateObj = \DateTime::createFromFormat('!m', $payroll->salary_month);

                    $requestArray [] = array(
                        'Id' => $key + 1,
                        'Name' => $payroll->name,
                        'Code' => $payroll->code,
                        'Basic Salary' => number_format($payroll->Basicsalary, 2),
                        'HRA' => number_format($payroll->hra, 2),
                        'TA' => number_format($payroll->travel_allowance, 2),
                        'Loan deduction' => number_format($payroll->loan_deduction, 2),
                        'Leave deduction' => number_format($payroll->leave_deduction, 2),
                        'Paid leave count' => $payroll->paid_leave_count,
                        'Gosi' => $payroll->gosi,
                        'Net salary' => number_format($payroll->net_salary, 2),
                        'Month' => $dateObj->format('F'),
                        'Year' => $payroll->salary_year
                    );
                }


                Excel::create('Payroll_List_' . date('Ymdhis'), function($excel) use ($requestArray) {
                    $excel->setTitle('Employees payroll details');
                    $excel->sheet('Payroll', function($sheet) use ($requestArray) {
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
     */
    public function generatePayroll() {
        $month = 10;
        $year = 2020;
        $startDate = date("Y-m-d", strtotime($year . "-" . $month . "-25"));
        $time = strtotime($startDate);
        $endDate = date("Y-m-d", strtotime("+1 month", $time));
        $employeePayrollDetails = [];
        //remove all payrolls in the same month and year
        \DB::table('employee_payroll')->where('salary_month', $month)->where('salary_year', $year)->delete();
        //collect all active employees salary details
        $salaryDetails = \DB::table('employees')->select(
                                'users.id', 'users.name', 'employees.user_id as employeeId', 'employees.code', 'employees.name', 'employees.salary', 'employees.housing_allowance', 'employees.transportation_charge', 'employees.employee_gosi','employees.employer_gosi')
                        ->join('users', 'employees.user_id', '=', 'users.id')
                        ->where('employees.status', 0)->get();


        foreach ($salaryDetails as $salaryDetail) {
            $employeePayrollDetails[$salaryDetail->id] = array('salary' => $salaryDetail->salary, 'hra' => $salaryDetail->housing_allowance, 'ta' => $salaryDetail->transportation_charge, 'gosi' => $salaryDetail->employee_gosi,'employer_gosi' =>$salaryDetail->employer_gosi ,'loanAmount' => 0, 'leaveAmount' => 0, 'leaveCount' => 0, 'paidleaveCount' => 0);
        }
        //all active employees loan details
        $loans = \DB::table('users')->select(
                                'users.id', 'loan_installment.amount')
                        ->join('employees', 'employees.user_id', '=', 'users.id')
                        ->join('employee_loans', 'employee_loans.user_id', '=', 'users.id')
                        ->join('loan_installment', 'employee_loans.id', '=', 'loan_installment.loan_id')
                        ->where('paid_status', 0)
                        ->where('skip_status', 0)
                        ->whereMonth('loan_installment.installment_date', '=', $month)->whereYear('loan_installment.installment_date', '=', $year)->get();


        //all active employees leave details
//        $leaves = \DB::table('employee_leaves')->select(
//                                'users.id as userId', 'users.name', 'employees.code', 'employee_leaves.days', 'employee_leaves.date_from', 'employee_leaves.date_to', 'employee_leaves.remarks', 'employee_leaves.leave_type_id', \DB::raw("sum(datediff(least(employee_leaves.date_to, '{$endDate}'),greatest(employee_leaves.date_from,'{$startDate}' ))+1) as leavetaken"), \DB::raw("least(employee_leaves.date_to, '{$endDate}')"), \DB::raw("greatest(employee_leaves.date_from, '{$startDate}')"))
//                        ->join('users', 'employee_leaves.user_id', '=', 'users.id')
//                        ->join('employees', 'employees.user_id', '=', 'users.id')
//                        ->where('employee_leaves.status', 1)
//                         ->where('employees.status', 0)
//                        ->groupBy('employee_leaves.user_id')->where('employee_leaves.date_from', '<=', $endDate)->where('employee_leaves.date_to', '>=', $startDate)->get();

        $leaves = \DB::table('employee_leaves')->select(
                                'users.id as userId', 'users.name', 'employees.code', 'employee_leaves.days', 'employee_leaves.date_from', 'employee_leaves.date_to', 'employee_leaves.remarks', 'employee_leaves.leave_type_id', \DB::raw("sum(datediff(least(employee_leaves.date_to, '{$endDate}'),greatest(employee_leaves.date_from, employees.date_of_joining ))+1) as leavetaken"), \DB::raw("TIMESTAMPDIFF(MONTH,employees.date_of_joining,'{$endDate}') as totalMonth"))
                        ->join('users', 'employee_leaves.user_id', '=', 'users.id')
                        ->join('employees', 'employees.user_id', '=', 'users.id')
                        ->where('employee_leaves.status', 1)
                        ->where('employees.status', 0)
                        ->groupBy('employee_leaves.user_id')->where('employee_leaves.date_from', '<=', $endDate)->where('employee_leaves.date_to', '>=', 'employees.date_of_joining')->get();

        //Find paid leave count                   
        $totalPaidLeaveCounts = \DB::table('employee_payroll')->select(
                                'users.id as userId', \DB::raw("sum(employee_payroll.paid_leave_count) as totalPaidleave"))
                        ->join('users', 'employee_payroll.user_id', '=', 'users.id')
                        ->join('employees', 'employees.user_id', '=', 'users.id')
                        ->where('employees.status', 0)
                        ->groupBy('employee_payroll.user_id')->get();



        foreach ($totalPaidLeaveCounts as $totalPaidLeaveCount) {
            $employeePayrollDetails[$totalPaidLeaveCount->userId]['paidleaveCount'] = $totalPaidLeaveCount->totalPaidleave;
        }


        foreach ($loans as $loan) {
            $employeePayrollDetails[$loan->userId]['loanAmount'] = $loan->amount;
        }

        foreach ($leaves as $leave) {

            $leaveExceedCount = $leave->leavetaken - ($leave->totalMonth * 2.5) - $employeePayrollDetails[$leave->userId]['paidleaveCount'];

            if ($leaveExceedCount > 0) {
                $totalMonthlySalary = $employeePayrollDetails[$leave->userId]['salary'] + $employeePayrollDetails[$leave->userId]['hra'] + $employeePayrollDetails[$leave->userId]['ta'];
                $employeePayrollDetails[$leave->userId]['leaveAmount'] = ($totalMonthlySalary / 30) * $leaveExceedCount;
                $employeePayrollDetails[$leave->userId]['leaveCount'] = $leaveExceedCount;
            }
        }

        //Calculate monthly salary
        $dateTime = date('Y-m-d H:i');
        $insertArray = array();

        foreach ($employeePayrollDetails as $key => $employeePayrollDetail) {
            $insertArray[$key]['user_id'] = $key;
            $insertArray[$key]['salary_month'] = $month;
            $insertArray[$key]['salary_year'] = $year;

            $insertArray[$key]['loan_deduction'] = $employeePayrollDetail['loanAmount'];
            $insertArray[$key]['leave_deduction'] = $employeePayrollDetail['leaveAmount'];
            $insertArray[$key]['salary'] = $employeePayrollDetail['salary'];
            $insertArray[$key]['created_date'] = $dateTime;
            $insertArray[$key]['net_salary'] = ($employeePayrollDetail['salary'] + $employeePayrollDetail['hra'] + $employeePayrollDetail['ta']) - ($employeePayrollDetail['loanAmount'] + $employeePayrollDetail['leaveAmount']);
            $insertArray[$key]['hra'] = $employeePayrollDetail['hra'];
            $insertArray[$key]['travel_allowance'] = $employeePayrollDetail['ta'];
            $insertArray[$key]['gosi'] = $employeePayrollDetail['gosi'];
            $insertArray[$key]['employer_gosi'] = $employeePayrollDetail['employer_gosi'];
            $insertArray[$key]['paid_leave_count'] = $employeePayrollDetail['leaveCount'];
        }
        if (count($insertArray) > 0) {

            //insert values into table
            \DB::table('employee_payroll')->insert($insertArray); // Query Builder approach
        }


        return redirect()->action('PayrollController@showPayrolls');
    }

}
