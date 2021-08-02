<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller {

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
    public function showVacationBalance() {


        $leaves = \DB::table('employee_leaves')->select(
                                'users.id', 'users.name', 'employees.code', 'employee_leaves.days', 'employee_leaves.date_from', 'employee_leaves.date_to', 'leave_types.leave_type', 'employee_leaves.remarks', 'employee_leaves.leave_type_id', \DB::raw("sum(employee_leaves.days) AS totalLeaves"))
                        ->join('users', 'employee_leaves.user_id', '=', 'users.id')
                        ->join('employees', 'employees.user_id', '=', 'users.id')
                        ->join('leave_types', 'leave_types.id', '=', 'employee_leaves.leave_type_id')
                        ->where('employee_leaves.status', 1)
                        ->groupBy('employee_leaves.user_id', 'employee_leaves.leave_type_id')->paginate(20);




        $column = '';
        $string = '';
        $dateFrom = '';
        $dateTo = '';
        return view('hrms.report.show_vacation_list', compact('leaves', 'column', 'string', 'dateFrom', 'dateTo'));
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
/**
 * 
 * @param Request $request
 * @return type
 */
    public function searchLeave(Request $request) {
        try {
            $string = $request->string;


            $column = $request->column;
            $dateTo = $request->dateTo;
            $dateFrom = $request->dateFrom;

            $data = ['name' => 'users.name', 'code' => 'employees.code', 'days' => 'employee_leaves.days', 'leave_type' => 'leave_types.leave_type'];

            if ($request->button == 'Search') {
                /**
                 * First we build a query string which is common in both cases whether we have a condition set or not
                 */
                $leaves = \DB::table('employee_leaves')->select(
                                'users.id', 'users.name', 'employees.code', 'employee_leaves.days', 'employee_leaves.date_from', 'employee_leaves.date_to', 'leave_types.leave_type', 'employee_leaves.remarks', 'employee_leaves.leave_type_id', \DB::raw("sum(employee_leaves.days) AS totalLeaves"))
                        ->join('users', 'employee_leaves.user_id', '=', 'users.id')
                        ->join('employees', 'employees.user_id', '=', 'users.id')
                        ->join('leave_types', 'leave_types.id', '=', 'employee_leaves.leave_type_id')
                        ->where('employee_leaves.status', 1);



                if (!empty($column) && !empty($string) && empty($dateFrom) && empty($dateTo)) {

                    $leaves = $leaves->whereRaw($data[$column] . " like '%" . $string . "%' ")->groupBy('employee_leaves.user_id', 'employee_leaves.leave_type_id')->paginate(20);
                } elseif (!empty($dateFrom) && !empty($dateTo) && empty($column) && empty($string)) {
                    $dateTo = date_format(date_create($request->dateTo), 'Y-m-d');
                    $dateFrom = date_format(date_create($request->dateFrom), 'Y-m-d');
                    $leaves = $leaves->whereBetween('date_from', [$dateFrom, $dateTo])->groupBy('employee_leaves.user_id', 'employee_leaves.leave_type_id')->paginate(20);
                } elseif (!empty($column) && !empty($string) && !empty($dateFrom) && !empty($dateTo)) {
                    $dateTo = date_format(date_create($request->dateTo), 'Y-m-d');
                    $dateFrom = date_format(date_create($request->dateFrom), 'Y-m-d');
                    $leaves = $leaves->whereRaw($data[$column] . " like '%" . $string . "%'")->whereBetween('date_from', [$dateFrom, $dateTo])->groupBy('employee_leaves.user_id', 'employee_leaves.leave_type_id')->paginate(20);
                } else {
                    $leaves = $leaves->groupBy('employee_leaves.user_id', 'employee_leaves.leave_type_id')->paginate(20);
                }

                $post = 'post';

                return view('hrms.report.show_vacation_list', compact('leaves', 'post', 'column', 'string', 'dateFrom', 'dateTo'));
            } else {
                /**
                 * First we build a query string which is common in both cases whether we have a condition set or not
                 */
                $leaves = \DB::table('users')->select(
                                'employee_leaves.id', 'users.name', 'employees.code', 'employee_leaves.days', 'employee_leaves.date_from', 'employee_leaves.date_to', 'leave_types.leave_type', \DB::raw("sum(employee_leaves.days) AS totalLeaves"))
                        ->join('employees', 'employees.user_id', '=', 'users.id')
                        ->join('employee_leaves', 'employee_leaves.user_id', '=', 'users.id')
                        ->join('leave_types', 'leave_types.id', '=', 'employee_leaves.leave_type_id')
                        ->where('employee_leaves.status', 1);
                if (!empty($column) && !empty($string) && empty($dateFrom) && empty($dateTo)) {
                    $leaves = $leaves->whereRaw($data[$column] . " like '%" . $string . "%' ")->groupBy('employee_leaves.user_id', 'employee_leaves.leave_type_id')->get();
                } elseif (!empty($dateFrom) && !empty($dateTo) && empty($column) && empty($string)) {
                    $dateTo = date_format(date_create($request->dateTo), 'Y-m-d');
                    $dateFrom = date_format(date_create($request->dateFrom), 'Y-m-d');
                    $leaves = $leaves->whereBetween('date_from', [$dateFrom, $dateTo])->groupBy('employee_leaves.user_id', 'employee_leaves.leave_type_id')->get();
                } elseif (!empty($column) && !empty($string) && !empty($dateFrom) && !empty($dateTo)) {
                    $dateTo = date_format(date_create($request->dateTo), 'Y-m-d');
                    $dateFrom = date_format(date_create($request->dateFrom), 'Y-m-d');
                    $leaves = $leaves->whereRaw($data[$column] . " like '%" . $string . "%'")->whereBetween('date_from', [$dateFrom, $dateTo])->groupBy('employee_leaves.user_id', 'employee_leaves.leave_type_id')->get();
                } else {
                    $leaves = $leaves->groupBy('employee_leaves.user_id', 'employee_leaves.leave_type_id')->get();
                }


                $requestArray[] = ['id', 'Name', 'Code', 'Leave type', 'Total leave','Balance leave'];

                foreach ($leaves as $key => $leave) {
                    $requestArray [] = array(
                        'Id' => $key + 1,
                        'Name' => $leave->name,
                        'Code' => $leave->code,
                        'Leave type' => $leave->leave_type,
                        'Total leave' => $leave->totalLeaves,
                        'Balance leave' => 23-$leave->totalLeaves,
                    );
                }


                Excel::create('Vacation_List_' . date('Ymdhis'), function($excel) use ($requestArray) {
                    $excel->setTitle('Employees vacation details');
                    $excel->sheet('Vacation', function($sheet) use ($requestArray) {
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showTerminationDetails() {


        $terminations = \DB::table('employees')->select(
                        'users.id', 'users.name', 'employees.code', 'employees.date_of_joining', 'employees.date_of_resignation')
                ->join('users', 'employees.user_id', '=', 'users.id')
                ->where('employees.status', 0)
                ->paginate(20);

        $column = '';
        $string = '';
        $dateFrom = '';
        $dateTo = '';
        return view('hrms.report.termination_report_list', compact('terminations', 'column', 'string', 'dateFrom', 'dateTo'));
    }
/**
 * 
 * @param Request $request
 * @return type
 */
    public function searchTermination(Request $request) {
        try {
            $string = $request->string;


            $column = $request->column;
            $dateTo = $request->dateTo;
            $dateFrom = $request->dateFrom;

            $data = ['name' => 'users.name', 'code' => 'employees.code'];

            if ($request->button == 'Search') {
                /**
                 * First we build a query string which is common in both cases whether we have a condition set or not
                 */
                $terminations = \DB::table('employees')->select(
                                'users.id', 'users.name', 'employees.code', 'employees.date_of_joining', 'employees.date_of_resignation')
                        ->join('users', 'employees.user_id', '=', 'users.id')
                        ->where('employees.status', 0);



                if (!empty($column) && !empty($string) && empty($dateFrom) && empty($dateTo)) {

                    $terminations = $terminations->whereRaw($data[$column] . " like '%" . $string . "%' ")->paginate(20);
                } elseif (!empty($dateFrom) && !empty($dateTo) && empty($column) && empty($string)) {
                    $dateTo = date_format(date_create($request->dateTo), 'Y-m-d');
                    $dateFrom = date_format(date_create($request->dateFrom), 'Y-m-d');
                    $terminations = $terminations->whereBetween('date_of_resignation', [$dateFrom, $dateTo])->paginate(20);
                } elseif (!empty($column) && !empty($string) && !empty($dateFrom) && !empty($dateTo)) {
                    $dateTo = date_format(date_create($request->dateTo), 'Y-m-d');
                    $dateFrom = date_format(date_create($request->dateFrom), 'Y-m-d');
                    $terminations = $terminations->whereRaw($data[$column] . " like '%" . $string . "%'")->whereBetween('date_of_resignation', [$dateFrom, $dateTo])->paginate(20);
                } else {
                    $terminations = $terminations->paginate(20);
                }

                $post = 'post';

                return view('hrms.report.termination_report_list', compact('terminations', 'post', 'column', 'string', 'dateFrom', 'dateTo'));
            } else {
                /**
                 * First we build a query string which is common in both cases whether we have a condition set or not
                 */
                $terminations = \DB::table('employees')->select(
                                'users.id', 'users.name', 'employees.code', 'employees.date_of_joining', 'employees.date_of_resignation')
                        ->join('users', 'employees.user_id', '=', 'users.id')
                        ->where('employees.status', 0);
                if (!empty($column) && !empty($string) && empty($dateFrom) && empty($dateTo)) {
                    $terminations = $terminations->whereRaw($data[$column] . " like '%" . $string . "%' ")->get();
                } elseif (!empty($dateFrom) && !empty($dateTo) && empty($column) && empty($string)) {
                    $dateTo = date_format(date_create($request->dateTo), 'Y-m-d');
                    $dateFrom = date_format(date_create($request->dateFrom), 'Y-m-d');
                    $terminations = $terminations->whereBetween('date_of_resignation', [$dateFrom, $dateTo])->get();
                } elseif (!empty($column) && !empty($string) && !empty($dateFrom) && !empty($dateTo)) {
                    $dateTo = date_format(date_create($request->dateTo), 'Y-m-d');
                    $dateFrom = date_format(date_create($request->dateFrom), 'Y-m-d');
                    $terminations = $terminations->whereRaw($data[$column] . " like '%" . $string . "%'")->whereBetween('date_of_resignation', [$dateFrom, $dateTo])->get();
                } else {
                    $terminations = $terminations->get();
                }




                $requestArray[] = ['id', 'Name', 'Code', 'Joining date', 'Resignation date'];

                foreach ($terminations as $key => $termination) {
                    $requestArray [] = array(
                        'Id' => $key + 1,
                        'Name' => $termination->name,
                        'Code' => $termination->code,
                        'Joining date' => date('d-m-Y', strtotime($termination->date_of_joining)),
                        'Resignation date' => date('d-m-Y', strtotime($termination->date_of_resignation)),
                    );
                }

                Excel::create('Termination_List_' . date('Ymdhis'), function($excel) use ($requestArray) {
                    $excel->setTitle('Employees vacation details');
                    $excel->sheet('Vacation', function($sheet) use ($requestArray) {
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoanDetails() {


    $loans = \DB::table('users')->select(
                                'users.id', 'users.name', 'employees.code', 'employee_loans.amount', 'employee_loans.manager_approve_status', 'employee_loans.finance_approve_status', 'employee_loans.reason', 'employee_loans.installment_number', 'employee_loans.applied_to',\DB::raw("(select sum(amount) from loan_installment where loan_id=employee_loans.id  and paid_status=0)  AS unpaidBalance"),\DB::raw("(case employee_loans.loan_type_id when 1 then 'Car loan' when 2 then 'Housing Loan'  when 3 then 'Air ticket loan' when 4 then 'Personal Loan' when 5 then 'Study Loan' when 6 then 'Study Loan'  else 'others' end) AS typeString"))
                        ->join('employees', 'employees.user_id', '=', 'users.id')
                        ->join('employee_loans', 'employee_loans.user_id', '=', 'users.id')
                        ->where('employee_loans.finance_approve_status',1)->paginate(20);

        $column = '';
        $string = '';
        $dateFrom = '';
        $dateTo = '';
        return view('hrms.report.loan_report_list', compact('loans', 'column', 'string', 'dateFrom', 'dateTo'));
    }
/**
 * 
 * @param Request $request
 * @return type
 */
    public function searchLoandetails(Request $request) {
        try {
            $string = $request->string;


            $column = $request->column;
            $dateTo = $request->dateTo;
            $dateFrom = $request->dateFrom;

            $data = ['name' => 'users.name', 'code' => 'employees.code','loantype' =>"(case employee_loans.loan_type when 1 then 'Car loan' when 2 then 'Housing Loan'  when 3 then 'Air ticket loan' when 4 then 'Personal Loan' when 5 then 'Study Loan' when 6 then 'Study Loan'  else 'others' end)"];

            if ($request->button == 'Search') {
                /**
                 * First we build a query string which is common in both cases whether we have a condition set or not
                 */
              
    $loans = \DB::table('users')->select(
                                'users.id', 'users.name', 'employees.code', 'employee_loans.amount', 'employee_loans.manager_approve_status', 'employee_loans.finance_approve_status', 'employee_loans.reason', 'employee_loans.installment_number', 'employee_loans.applied_to',\DB::raw("(select sum(amount) from loan_installment where loan_id=employee_loans.id  and paid_status=0)  AS unpaidBalance"),\DB::raw("(case employee_loans.loan_type when 1 then 'Car loan' when 2 then 'Housing Loan'  when 3 then 'Air ticket loan' when 4 then 'Personal Loan' when 5 then 'Study Loan' when 6 then 'Study Loan'  else 'others' end) AS typeString"))
                        ->join('employees', 'employees.user_id', '=', 'users.id')
                        ->join('employee_loans', 'employee_loans.user_id', '=', 'users.id')
                        ->where('employee_loans.finance_approve_status',1);



                if (!empty($column) && !empty($string) && empty($dateFrom) && empty($dateTo)) {
                    $loans = $loans->whereRaw($data[$column] . " like '%" . $string . "%' ")->paginate(20);
                  
                } elseif (!empty($dateFrom) && !empty($dateTo) && empty($column) && empty($string)) {
                    $dateTo = date_format(date_create($request->dateTo), 'Y-m-d');
                    $dateFrom = date_format(date_create($request->dateFrom), 'Y-m-d');
                    $loans = $loans->whereBetween('applied_to', [$dateFrom, $dateTo])->paginate(20);
                } elseif (!empty($column) && !empty($string) && !empty($dateFrom) && !empty($dateTo)) {
                    $dateTo = date_format(date_create($request->dateTo), 'Y-m-d');
                    $dateFrom = date_format(date_create($request->dateFrom), 'Y-m-d');
                    $loans = $loans->whereRaw($data[$column] . " like '%" . $string . "%'")->whereBetween('applied_to', [$dateFrom, $dateTo])->paginate(20);
                } else {
                    $loans = $loans->paginate(20);
                }

                $post = 'post';

                return view('hrms.report.loan_report_list', compact('loans', 'post', 'column', 'string', 'dateFrom', 'dateTo'));
            } else {
                /**
                 * First we build a query string which is common in both cases whether we have a condition set or not
                 */
               $loans = \DB::table('users')->select(
                                'users.id', 'users.name', 'employees.code', 'employee_loans.amount', 'employee_loans.manager_approve_status', 'employee_loans.finance_approve_status', 'employee_loans.reason', 'employee_loans.installment_number', 'employee_loans.applied_to',\DB::raw("(select sum(amount) from loan_installment where loan_id=employee_loans.id  and paid_status=0)  AS unpaidBalance"),\DB::raw("(case employee_loans.loan_type when 1 then 'Car loan' when 2 then 'Housing Loan'  when 3 then 'Air ticket loan' when 4 then 'Personal Loan' when 5 then 'Study Loan' when 6 then 'Study Loan'  else 'others' end) AS typeString"))
                        ->join('employees', 'employees.user_id', '=', 'users.id')
                        ->join('employee_loans', 'employee_loans.user_id', '=', 'users.id')
                        ->where('employee_loans.finance_approve_status',1);
                if (!empty($column) && !empty($string) && empty($dateFrom) && empty($dateTo)) {
                    $loans = $loans->whereRaw($data[$column] . " like '%" . $string . "%' ")->get();
                } elseif (!empty($dateFrom) && !empty($dateTo) && empty($column) && empty($string)) {
                    $dateTo = date_format(date_create($request->dateTo), 'Y-m-d');
                    $dateFrom = date_format(date_create($request->dateFrom), 'Y-m-d');
                    $loans = $loans->whereBetween('applied_to', [$dateFrom, $dateTo])->get();
                } elseif (!empty($column) && !empty($string) && !empty($dateFrom) && !empty($dateTo)) {
                    $dateTo = date_format(date_create($request->dateTo), 'Y-m-d');
                    $dateFrom = date_format(date_create($request->dateFrom), 'Y-m-d');
                    $loans = $loans->whereRaw($data[$column] . " like '%" . $string . "%'")->whereBetween('applied_to', [$dateFrom, $dateTo])->get();
                } else {
                    $loans = $loans->get();
                }




                $requestArray[] = ['id', 'Name', 'Code', 'Loan amount','Loan type', 'Applied date','Total Installment', 'Unpaid amount'];

                foreach ($loans as $key => $loan) {
                    $requestArray [] = array(
                        'Id' => $key + 1,
                        'Name' => $loan->name,
                        'Code' => $loan->code,
                        'Loan amount' => number_format($loan->amount,2),
                        'Loan type' => $loan->typeString,
                        'Applied date' => date('d-m-Y', strtotime($loan->applied_to)),
                        'Total Installment' => $loan->installment_number,
                        'Unpaid amount' => number_format($loan->unpaidBalance,2)
                    );
                }




                Excel::create('Loan_List_' . date('Ymdhis'), function($excel) use ($requestArray) {
                    $excel->setTitle('Employees vacation details');
                    $excel->sheet('Vacation', function($sheet) use ($requestArray) {
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
    
    public function gosiDetails() {
                 
           $gosidetails = \DB::table('employee_payroll')->select(
                                'users.id', 'users.name', 'employees.user_id as employeeId', 'employees.code', 'employees.name', 'employee_payroll.salary',   'employee_payroll.salary_month', 'employee_payroll.salary_year','employee_payroll.gosi','employee_payroll.employer_gosi','employee_payroll.hra')
                        ->join('employees', 'employees.user_id', '=', 'employee_payroll.user_id')
                        ->join('users', 'employees.user_id', '=', 'users.id')
                        ->where('employee_payroll.salary_month', '=', date('m'))
                        ->where('employee_payroll.salary_year', '=', date('Y'))->orderBy('employee_payroll.created_date', 'desc')->paginate(20);


        $column = '';
        $string = '';
        $dateFrom = '';
        $dateTo = '';
        return view('hrms.report.gosi_report_list', compact('gosidetails', 'column', 'string', 'dateFrom', 'dateTo'));  
    }
    /**
 * 
 * @param Request $request
 * @return type
 */
    public function searchGosidetails(Request $request) {
        try {
            $string = $request->string;


            $column = $request->column;
            $dateTo = $request->dateTo;
            $dateFrom = $request->dateFrom;

            $data = ['name' => 'users.name', 'code' => 'employees.code', 'year'=>'employee_payroll.salary_year'];

            if ($request->button == 'Search') {
                /**
                 * First we build a query string which is common in both cases whether we have a condition set or not
                 */
              
      $gosidetails = \DB::table('employee_payroll')->select(
                                'users.id', 'users.name', 'employees.user_id as employeeId', 'employees.code', 'employees.name', 'employee_payroll.salary',   'employee_payroll.salary_month', 'employee_payroll.salary_year','employee_payroll.gosi','employee_payroll.employer_gosi','employee_payroll.hra')
                        ->join('employees', 'employees.user_id', '=', 'employee_payroll.user_id')
                        ->join('users', 'employees.user_id', '=', 'users.id');



                if (!empty($column) && !empty($string) && empty($dateFrom) && empty($dateTo)) {
                  
                    $gosidetails = $gosidetails->whereRaw($data[$column] . " like '%" . $string . "%' ")->paginate(20);
                  
                } elseif (!empty($dateFrom) && !empty($dateTo) && empty($column) && empty($string)) {
                     
                    $gosidetails = $gosidetails->whereBetween('employee_payroll.salary_month', [$dateFrom, $dateTo])->paginate(20);
                } elseif (!empty($column) && !empty($string) && !empty($dateFrom) && !empty($dateTo)) {
                    
                    $gosidetails = $gosidetails->whereRaw($data[$column] . " like '%" . $string . "%'")->whereBetween('employee_payroll.salary_month', [$dateFrom, $dateTo])->paginate(20);
                } else {
                     
                    $gosidetails = $gosidetails->paginate(20);
                }

                $post = 'post';

                return view('hrms.report.gosi_report_list', compact('gosidetails', 'post', 'column', 'string', 'dateFrom', 'dateTo'));
            } else {
                /**
                 * First we build a query string which is common in both cases whether we have a condition set or not
                 */
               $gosidetails =  \DB::table('employee_payroll')->select(
                                'users.id', 'users.name', 'employees.user_id as employeeId', 'employees.code', 'employees.name', 'employee_payroll.salary',   'employee_payroll.salary_month', 'employee_payroll.salary_year','employee_payroll.gosi','employee_payroll.employer_gosi','employee_payroll.hra')
                        ->join('employees', 'employees.user_id', '=', 'employee_payroll.user_id')
                        ->join('users', 'employees.user_id', '=', 'users.id');
                if (!empty($column) && !empty($string) && empty($dateFrom) && empty($dateTo)) {
         
                    $gosidetails = $gosidetails->whereRaw($data[$column] . " like '%" . $string . "%' ")->get();
                  
                } elseif (!empty($dateFrom) && !empty($dateTo) && empty($column) && empty($string)) {
      
                    $gosidetails = $gosidetails->whereBetween('employee_payroll.salary_month', [$dateFrom, $dateTo])->get();
                } elseif (!empty($column) && !empty($string) && !empty($dateFrom) && !empty($dateTo)) {
  
                    $gosidetails = $gosidetails->whereRaw($data[$column] . " like '%" . $string . "%'")->whereBetween('employee_payroll.salary_month', [$dateFrom, $dateTo])->get();
                } else {
 
                    $gosidetails = $gosidetails->get();
                }



                $requestArray[] = ['id', 'Name', 'Code', 'Salary','HRA', 'Employee gosi','Employer gosi', 'Month','Year'];

                foreach ($gosidetails as $key => $gosidetail) {
                    $requestArray [] = array(
                        'Id' => $key + 1,
                        'Name' => $gosidetail->name,
                        'Code' => $gosidetail->code,
                        'Salary' => number_format($gosidetail->salary,2),
                        'HRA' => $gosidetail->hra,
                        'Employee gosi' => $gosidetail->gosi,
                        'Employer gosi' => $gosidetail->employer_gosi,
                        'Month' => getMonthString($gosidetail->salary_month),
                        'Year' => $gosidetail->salary_year
                    );
                }


                Excel::create('Gosi_Report_' . date('Ymdhis'), function($excel) use ($requestArray) {
                    $excel->setTitle('Employees gosi details');
                    $excel->sheet('Vacation', function($sheet) use ($requestArray) {
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

}
