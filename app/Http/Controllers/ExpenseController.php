<?php

namespace App\Http\Controllers;

use App\Expense;
use App\Models\Employee;
use App\User;
use App\EmployeeLeaves;

use Illuminate\Http\Request;

class ExpenseController extends Controller {

    /**
     * 
     * @return type
     */
    public function addExpense() {

        $emps = User::get();
        return view('hrms.expense.add_expense', compact('emps'));
    }

    /**
     * 
     * @param Request $request
     * @return type
     */
    public function processExpense(Request $request) {
        $expense = new Expense();
        $expense->user_id = $request->emp_id;
        $expense->item = $request->item;
        $expense->purchase_from = $request->purchase_from;
        $expense->date_of_purchase = date_format(date_create($request->date_of_purchase), 'Y-m-d');
        $expense->amount = $request->amount;
        $expense->save();

        \Session::flash('flash_message', 'Expense successfully added!');
        return redirect()->back();
    }

    /**
     * 
     * @return type
     */
    public function showExpense() {
        $expenses = Expense::with('employee')->paginate(5);
        return view('hrms.expense.show_expenses', compact('expenses'));
    }

    /**
     * 
     * @param type $id
     * @return type
     */
    public function showEdit($id) {

        $expenses = Expense::with('employee')->where('id', $id)->first();
        $emps = Employee::get();
        return view('hrms.expense.edit_expense', compact('emps', 'expenses'));
    }

    /**
     * 
     * @param type $id
     * @param Request $request
     * @return type
     */
    public function doEdit($id, Request $request) {

        $expense = Expense::with('employee')->where('id', $id)->first();
        $expense->user_id = $request->emp_id;
        $expense->item = $request->item;
        $expense->purchase_from = $request->purchase_from;
        $expense->date_of_purchase = date_format(date_create($request->date_of_purchase), 'Y-m-d');
        $expense->amount = $request->amount;
        $expense->save();


        \Session::flash('flash_message', 'Expense successfully updated!');
        return redirect('expense-list');
    }

    /**
     * 
     * @param type $id
     * @return type
     */
    public function doDelete($id) {
        $expense = Expense::find($id);
        $expense->delete();

        \Session::flash('flash_message', 'Expense successfully Deleted!');
        return redirect('expense-list');
    }

    /**
     * 
     */
    public function checkticketAvailability(Request $request) {
      
        $employeeId = $request->get('empId');
        $leaveId = $request->get('leaveId');
        $leaveDetails =  \DB::table('travel_expense as te')->join('employee_leaves as el' ,'el.id', '=', 'te.leave_id')->where('te.leave_id',$leaveId)->select('*')->first();
        $wantedSelfticket = 1;
        $wantedSpouseticket = $leaveDetails->spouse_ticket;
        $wantedChildticket = $leaveDetails->children_ticket;
    
        $availableTicketDetails = \DB::table('employee_current_year_ticket')->where('employee_id',$employeeId)->where('period_from','<=',date('Y-m-d', strtotime($leaveDetails->date_from)))->where('period_to','>=',date('Y-m-d', strtotime($leaveDetails->date_from)))->select('self_ticket_taken as selfticketCount','spouce_ticket_taken as spouceticketCount','children_ticket_taken as childticketCount','self_ticket_count','spouce_ticket_count','children_ticket_count')->first();
        //dd($availableTicketDetails->toSql(), $availableTicketDetails->getBindings());
        $returnArray['status'] = true;
        $returnArray['selfticketCount'] = 0;
        $returnArray['spouceticketCount'] = 0;
        $returnArray['childticketCount'] = 0;
        $returnArray['totalCount'] =  0;
        
        if($availableTicketDetails && count(get_object_vars($availableTicketDetails)) > 0) {
         
         $returnArray['selfticketCount'] = $availableTicketDetails->self_ticket_count - $availableTicketDetails->selfticketCount;
         $returnArray['spouceticketCount'] =  $availableTicketDetails->spouce_ticket_count - $availableTicketDetails->spouceticketCount ;
         $returnArray['childticketCount'] =  $availableTicketDetails->children_ticket_count - $availableTicketDetails->childticketCount; 
        }
        return response()->json($returnArray);
    }

}
