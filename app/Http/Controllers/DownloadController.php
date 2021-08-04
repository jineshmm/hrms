<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\EmployeeLeaves;

class DownloadController extends Controller
{
    public function downloadForms($name)
    {
        $headers=['Content-Type'=>' text/html; charset=utf-8'];
        $pathToFile = public_path('forms/'). $name;
        return response()->download($pathToFile,$name,$headers);
    }
    
    public function downloadLeavedocuments($leaveId, $type=0){
        $headers=['Content-Type'=>' text/html; charset=utf-8'];
        $employeeLeave = EmployeeLeaves::where('id', $leaveId)->first();
        if($type ==1) {
          $filename = $employeeLeave->tickets->ticket_file;  
        } else {
           $filename = $employeeLeave->exitReentry->uploaded_file; 
        }
 
        $pathToFile = storage_path('Leavedocuments/'.$leaveId)."/". $filename;
        return response()->download($pathToFile,$filename,$headers);
    }
    
    public function downloadEmployeedocuments($documentId){
        $headers=['Content-Type'=>' text/html; charset=utf-8'];
        $employeeDocs = \DB::table('employee_documents')->select('employees.id','employee_documents.filename')->join('employees', 'employees.id', '=', 'employee_documents.employee_id')->where('employee_documents.id',$documentId)->first();
        $filename = $employeeDocs->filename;  
        $pathToFile =storage_path('Employeedocuments/' . $employeeDocs->id)."/". $filename;
        return response()->download($pathToFile,$filename,$headers);
    }
    
}
