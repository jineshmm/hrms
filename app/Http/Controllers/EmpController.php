<?php

namespace App\Http\Controllers;

use App\Jobs\ExportData;
use App\Models\Employee;
use App\Models\EmployeeUpload;
use App\Models\Role;
use App\Models\UserRole;
use App\Promotion;
use App\User;
use App\Models\Department;
use App\EmployeeLeaves;
use App\Models\EmployeeDocuments;
use Carbon\Carbon;
use File;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Collection;

class EmpController extends Controller {

    public function addEmployee() {
        $roles = Role::get();
        $employee = Employee::get();
        $grades = $this->getGradeCollection();
        $departments = Department::get();
        return view('hrms.employee.add', compact('roles', 'employee', 'grades', 'departments'));
    }

    public function processEmployee(Request $request) {
       try {
        $filename = 'profile_pic.jpg';
     //dd($request);
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = str_random(12);
            $fileExt = $file->getClientOriginalExtension();
            $allowedExtension = ['jpg', 'jpeg', 'png'];
            $destinationPath = public_path('photos');
            if (!in_array($fileExt, $allowedExtension)) {
                return redirect()->back()->with('message', 'Extension not allowed');
            }
            $filename = $filename . '.' . $fileExt;
            $file->move($destinationPath, $filename);
        }

        $user = new User;
        $user->name = $request->emp_name;
        $user->email = $request->emp_email;
        $user->password = bcrypt('123456');
        $user->save();
        
            $emp = new Employee;
            $emp->photo = $filename;
            $emp->name = $request->emp_name;

            $qualification = $request->qualification_list;
                if($qualification == 'Other')
                {
                    $qualification = $request->qualification_text;
                    
                }
 
                $probation_period = $request->probation_period;
                if( $probation_period == 'Other')
                {
                     $probation_period = $request->probation_text;
                }
            $emp->code = $request->emp_code;
            
            $emp->gender = $request->gender;
            $emp->date_of_birth = date_format(date_create($request->dob), 'Y-m-d');
            $emp->date_of_joining = date_format(date_create($request->doj), 'Y-m-d');
            $emp->number = $request->mob_number;
            $emp->qualification = $qualification;
            $emp->emergency_number = $request->emer_number;
            $emp->pan_number = $request->get('pan_number','');
            $emp->father_name =  $request->get('father_name',''); 
            $emp->current_address =  $request->get('address','');
            $emp->permanent_address =  $request->get('permanent_address',''); 
            $emp->formalities =  $request->get('formalities',''); 
            $emp->offer_acceptance =  $request->get('offer_acceptance',''); 
            $emp->probation_period = $probation_period;
            $emp->date_of_confirmation = date_format(date_create($request->date_of_confirmation), 'Y-m-d');
            $emp->department_id = $request->get('department','') ;
            $emp->salary = $request->get('salary','') ;
            $emp->account_number =  $request->get('account_number',''); 
            $emp->bank_name =  $request->get('bank_name',''); 
            $emp->ifsc_code =  $request->get('ifsc_code',''); 
            $emp->pf_account_number =  $request->get('pf_account_number',''); 
            $emp->un_number =  $request->get('un_number',''); 
            $emp->pf_status =  $request->get('pf_status',''); 
            $emp->date_of_resignation = date_format(date_create($request->date_of_resignation), 'Y-m-d');
            $emp->notice_period =  $request->get('notice_period',''); 
            $emp->last_working_day = date_format(date_create($request->last_working_day), 'Y-m-d');
            $emp->full_final =  $request->get('full_final',''); 
            $emp->user_id = $user->id;

            //New columns 
            $emp->iqama_number =$request->get('emp_national_id','');
            $emp->direct_manager = $request->get('direct_manager', \Auth::user()->employee->id);
            $emp->housing_allowance = $request->get('housing_allowance','');
            $emp->transportation_charge = $request->get('transportation_allowance',''); 
            $emp->employee_type = $request->get('employee_type', 0);
            if ($emp->employee_type == 1) {
                $emp->employee_gosi = $request->employee_gosi;
            }
            $emp->employer_gosi = $request->employer_gosi;

            $emp->lastname = $request->emp_last_name;
            $emp->name_ar = $request->emp_name_ar;
            $emp->lastname_ar = $request->emp_last_name_ar;

            $emp->national_id = $request->emp_national_id;
            $emp->nationality = $request->emp_nationality;
            $emp->other_allowance = (trim($request->get("emp_other_allowance")) != '') ? $request->get("emp_other_allowance") : 0;

            $emp->grade = (trim($request->get("emp_grade")) != '') ? $request->get("emp_grade") : 3;
            
            //Ticket details
            $emp->self_ticket = 1;
            $emp->spouse_ticket = $request->ticket_spouse;
            $emp->children_ticket = $request->ticket_children;
            $emp->edited_by = \Auth::user()->employee->id;

            $emp->save();

            $userRole = new UserRole();
            $userRole->role_id = $request->role;
            $userRole->user_id = $user->id;
            $userRole->save();

            //Current period ticket details entry
            $this->leaveBalanceEntry($request, $emp->id);  
            
            
            //documents upload area
            if ($request->hasFile('emp_appointment_doc')) {
              $this->uploadEmpdocs($request, $user->id);  
            }
        } catch (\Exception $e) {
             $user->delete();
             \Session::flash('flash_message', 'Some error occurs');
             return redirect()->route('employee-manager');
        }
       \Session::flash('flash_message', 'Employee added successfully');

        return redirect()->route('employee-manager');
        //$emp->userrole()->create(['role_id' => $request->role]);

       // return json_encode(['title' => 'Success', 'message' => 'Employee added successfully', 'class' => 'modal-header-success']);
    }

    public function showEmployee() {
        $emps = User::with('employee', 'role.role', 'employee.department')->paginate(15);
        $column = '';
        $string = '';
        
   
        return view('hrms.employee.show_emp', compact('emps', 'column', 'string'));
    }

    public function showEdit($id) {
        //$emps = Employee::whereid($id)->with('userrole.role')->first();
        $emps = User::where('id', $id)->with('employee', 'role.role','employee.documents')->first();
        $employee = Employee::where('user_id', '!=', $id)->get();
        $roles = Role::get();
        $grades = $this->getGradeCollection();
        $departments = Department::get();

        return view('hrms.employee.add', compact('emps', 'roles', 'employee', 'grades', 'departments'));
    }

    public function doEdit(Request $request, $id) {
        $filename = public_path('photos/a.png');
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = str_random(12);
            $fileExt = $file->getClientOriginalExtension();
            $allowedExtension = ['jpg', 'jpeg', 'png'];
            $destinationPath = public_path('photos');
            if (!in_array($fileExt, $allowedExtension)) {
                return redirect()->back()->with('message', 'Extension not allowed');
            }
            $filename = $filename . '.' . $fileExt;
            $file->move($destinationPath, $filename);
        }
        $edit = Employee::where('user_id', $id)->first();
        $qualification = $request->qualification_list;
                if($qualification == 'Other')
                {
                    $qualification = $request->qualification_text;
                    
                }
 
                $prob_period = $request->probation_period;
                if($prob_period == 'Other')
                {
                     $prob_period = $request->probation_text;
                }
        $photo = $request->$filename;
        $emp_name = $request->name;
        $emp_code = $request->emp_code;
        $emp_status = $request->status;
        $gender = $request->gender;
        $dob = date_format(date_create($request->dob), 'Y-m-d');
        $doj = date_format(date_create($request->dob), 'Y-m-d');
        $mob_number = $request->mob_number;
       
        $emer_number = $request->emer_number;
        $pan_number =$request->get('pan_number','');
        $father_name = $request->get('father_name',''); 
        $address = $request->get('address','');
        $permanent_address = $request->get('permanent_address',''); 
        $formalities = $request->get('formalities',''); 
        $offer_acceptance = $request->get('offer_acceptance',''); 

        $doc = date_format(date_create($request->date_of_confirmation), 'Y-m-d');
        $department = $request->get('department','') ;
        $salary = $request->get('salary','') ;
        $account_number = $request->get('account_number',''); 
        $bank_name = $request->get('bank_name',''); 
        $ifsc_code = $request->get('ifsc_code',''); 
        $pf_account_number =$request->get('pf_account_number',''); 
        $un_number = $request->get('un_number',''); 
        $pf_status = $request->get('pf_status','');
        $dor = date_format(date_create($request->date_of_resignation), 'Y-m-d');
        $notice_period = $request->get('notice_period','');
        $last_working_day = date_format(date_create($request->last_working_day), 'Y-m-d');
        $full_final = $request->get('full_final',''); 

        //New columns 
        $iqama_number = $request->get('emp_national_id','');
        $direct_manager = $request->get('direct_manager', \Auth::user()->employee->id);
        $housing_allowance = $request->housing_allowance;
        $transportation_charge = $request->transportation_allowance;
        $employee_type = $request->get('employee_type');
        $employee_gosi = 0;
        if ($request->get('employee_type') == 1) {
            $employee_gosi = $request->employee_gosi;
        }
        $employer_gosi = $request->employer_gosi;

        

        $edit->nationality = $request->emp_nationality;
        $edit->other_allowance = (trim($request->get("emp_other_allowance")) != '') ? $request->get("emp_other_allowance") : 0;

        $edit->grade = (trim($request->get("emp_grade")) != '') ? $request->get("emp_grade") : 3;
        
        /*****************************************************************************************************/

        
        
        

        //$edit = Employee::findOrFail($id);


        if (!empty($photo)) {
            $edit->photo = $photo;
        }
        if (!empty($emp_name)) {
            $edit->name = $emp_name;
        }
        if (!empty($emp_code)) {
            $edit->code = $emp_code;
        }
        if (!empty($emp_status)) {
            $edit->status = $emp_status;
        }
        if (!empty($gender)) {
            $edit->gender = $gender;
        }
        if (!empty($dob)) {
            $edit->date_of_birth = $dob;
        }
        if (!empty($doj)) {
            $edit->date_of_joining = $doj;
        }
        if (!empty($mob_number)) {
            $edit->number = $mob_number;
        }
        if (!empty($qualification)) {
            $edit->qualification = $qualification;
        }
        if (!empty($emer_number)) {
            $edit->emergency_number = $emer_number;
        }
        if (!empty($pan_number)) {
            $edit->pan_number = $pan_number;
        }
        if (!empty($father_name)) {
            $edit->father_name = $father_name;
        }
        if (!empty($address)) {
            $edit->current_address = $address;
        }
        if (!empty($permanent_address)) {
            $edit->permanent_address = $permanent_address;
        }
        if (!empty($formalities)) {
            $edit->formalities = $formalities;
        }
        if (!empty($offer_acceptance)) {
            $edit->offer_acceptance = $offer_acceptance;
        }
        if (!empty($prob_period)) {
            $edit->probation_period = $prob_period;
        }
        if (!empty($doc)) {
            $edit->date_of_confirmation = $doc;
        }
        if (!empty($department)) {
            $edit->department_id = $department;
        }
        if (!empty($salary)) {
            $edit->salary = $salary;
        }
        if (!empty($account_number)) {
            $edit->account_number = $account_number;
        }
        if (!empty($bank_name)) {
            $edit->bank_name = $bank_name;
        }
        if (!empty($ifsc_code)) {
            $edit->ifsc_code = $ifsc_code;
        }
        if (!empty($pf_account_number)) {
            $edit->pf_account_number = $pf_account_number;
        }
        if (!empty($un_number)) {
            $edit->un_number = $un_number;
        }
        if (!empty($pf_status)) {
            $edit->pf_status = $pf_status;
        }
        if (!empty($dor)) {
            $edit->date_of_resignation = $dor;
        }
        if (!empty($notice_period)) {
            $edit->notice_period = $notice_period;
        }
        if (!empty($last_working_day)) {
            $edit->last_working_day = $last_working_day;
        }
        if (!empty($full_final)) {
            $edit->full_final = $full_final;
        }
        //new columns 

        if (!empty($iqama_number)) {
            $edit->iqama_number = $iqama_number;
             $edit->national_id = $iqama_number;
        }
        if (!empty($direct_manager)) {
            $edit->direct_manager = $direct_manager;
        }
        if (!empty($housing_allowance)) {
            $edit->housing_allowance = $housing_allowance;
        }
        if (!empty($transportation_charge)) {
            $edit->transportation_charge = $transportation_charge;
        }
        if (!empty($employee_type)) {
            $edit->employee_type = $employee_type;
        }
        if (!empty($employee_gosi)) {
            $edit->employee_gosi = $employee_gosi;
        }
        if (!empty($employer_gosi)) {
            $edit->employer_gosi = $employer_gosi;
        }
        
        if (!empty($request->emp_last_name)) {
            $edit->lastname = $request->emp_last_name;
        }
        if (!empty($request->emp_name_ar)) {
            $edit->name_ar = $request->emp_name_ar;
        }
        if (!empty($request->emp_last_name_ar)) {
             $edit->lastname_ar = $request->emp_last_name_ar;
        }
        
        //ticket details edit
        if (!empty($request->ticket_spouse)) {
             $edit->spouse_ticket = $request->ticket_spouse;
        }
        if (!empty($request->ticket_children)) {
             $edit->children_ticket = $request->ticket_children;
        }
        
        $edit->edited_by = \Auth::user()->employee->id;
        
        

        $edit->save();
        // Ticket entry of the joining year update
        $this->leaveBalanceEntry($request, $edit->id);
        
        
        
         \Session::flash('flash_message', 'Employee details successfully updated');

        return redirect()->route('employee-manager');

       
    }

    public function doDelete($id) {
        $user = User::where('id', $id)->with('employee')->first();
        $emps = Employee::find($user->employee['id']);
        $emps->status = 0;
        $emps->save();
        \Session::flash('flash_message', 'Employee successfully Deleted!');

        return redirect()->back();
    }

    public function importFile() {
        return view('hrms.employee.upload');
    }

    public function uploadFile(Request $request) {
        $files = Input::file('upload_file');

        /* try { */
        foreach ($files as $file) {
            Excel::load($file, function ($reader) {
                $rows = $reader->get(['emp_name', 'emp_code', 'emp_status', 'role', 'gender', 'dob', 'doj', 'mob_number', 'qualification', 'emer_number', 'pan_number', 'father_name', 'address', 'permanent_address', 'formalities', 'offer_acceptance', 'prob_period', 'doc', 'department_id', 'salary', 'account_number', 'bank_name', 'ifsc_code', 'pf_account_number', 'un_number', 'pf_status', 'dor', 'notice_period', 'last_working_day', 'full_final']);

                foreach ($rows as $row) {
                    \Log::info($row->role);
                    $user = new User;
                    $user->name = $row->emp_name;
                    $user->email = str_replace(' ', '_', $row->emp_name) . '@sipi-ip.sg';
                    $user->password = bcrypt('123456');
                    $user->save();

                    $attachment = new Employee();
                    $attachment->photo = '/img/Emp.jpg';
                    $attachment->name = $row->emp_name;
                    $attachment->code = $row->emp_code;
                    $attachment->status = convertStatus($row->emp_status);

                    if (empty($row->gender)) {
                        $attachment->gender = 'Not Exist';
                    } else {
                        $attachment->gender = $row->gender;
                    }
                    if (empty($row->dob)) {
                        $attachment->date_of_birth = '0000-00-00';
                    } else {
                        $attachment->date_of_birth = date('Y-m-d', strtotime($row->dob));
                    }
                    if (empty($row->doj)) {
                        $attachment->date_of_joining = '0000-00-00';
                    } else {
                        $attachment->date_of_joining = date('Y-m-d', strtotime($row->doj));
                    }
                    if (empty($row->mob_number)) {
                        $attachment->number = '1234567890';
                    } else {
                        $attachment->number = $row->mob_number;
                    }
                    if (empty($row->qualification)) {
                        $attachment->qualification = 'Not Exist';
                    } else {
                        $attachment->qualification = $row->qualification;
                    }
                    if (empty($row->emer_number)) {
                        $attachment->emergency_number = '1234567890';
                    } else {
                        $attachment->emergency_number = $row->emer_number;
                    }
                    if (empty($row->pan_number)) {
                        $attachment->pan_number = 'Not Exist';
                    } else {
                        $attachment->pan_number = $row->pan_number;
                    }
                    if (empty($row->father_name)) {
                        $attachment->father_name = 'Not Exist';
                    } else {
                        $attachment->father_name = $row->father_name;
                    }
                    if (empty($row->address)) {
                        $attachment->current_address = 'Not Exist';
                    } else {
                        $attachment->current_address = $row->address;
                    }
                    if (empty($row->permanent_address)) {
                        $attachment->permanent_address = 'Not Exist';
                    } else {
                        $attachment->permanent_address = $row->permanent_address;
                    }
                    if (empty($row->emp_formalities)) {
                        $attachment->formalities = '1';
                    } else {
                        $attachment->formalities = $row->emp_formalities;
                    }
                    if (empty($row->offer_acceptance)) {
                        $attachment->offer_acceptance = '1';
                    } else {
                        $attachment->offer_acceptance = $row->offer_acceptance;
                    }
                    if (empty($row->prob_period)) {
                        $attachment->probation_period = 'Not Exist';
                    } else {
                        $attachment->probation_period = $row->prob_period;
                    }
                    if (empty($row->doc)) {
                        $attachment->date_of_confirmation = '0000-00-00';
                    } else {
                        $attachment->date_of_confirmation = date('Y-m-d', strtotime($row->doc));
                    }
                    if (empty($row->department)) {
                        $attachment->department = 'Not Exist';
                    } else {
                        $attachment->department = $row->department;
                    }
                    if (empty($row->salary)) {
                        $attachment->salary = '00000';
                    } else {
                        $attachment->salary = $row->salary;
                    }
                    if (empty($row->account_number)) {
                        $attachment->account_number = 'Not Exist';
                    } else {
                        $attachment->account_number = $row->account_number;
                    }
                    if (empty($row->bank_name)) {
                        $attachment->bank_name = 'Not Exist';
                    } else {
                        $attachment->bank_name = $row->bank_name;
                    }
                    if (empty($row->ifsc_code)) {
                        $attachment->ifsc_code = 'Not Exist';
                    } else {
                        $attachment->ifsc_code = $row->ifsc_code;
                    }
                    if (empty($row->pf_account_number)) {
                        $attachment->pf_account_number = 'Not Exist';
                    } else {
                        $attachment->pf_account_number = $row->pf_account_number;
                    }
                    if (empty($row->un_number)) {
                        $attachment->un_number = 'Not Exist';
                    } else {
                        $attachment->un_number = $row->un_number;
                    }
                    if (empty($row->pf_status)) {
                        $attachment->pf_status = '1';
                    } else {
                        $attachment->pf_status = $row->pf_status;
                    }
                    if (empty($row->dor)) {
                        $attachment->date_of_resignation = '0000-00-00';
                    } else {
                        $attachment->date_of_resignation = date('Y-m-d', strtotime($row->dor));
                    }
                    if (empty($row->notice_period)) {
                        $attachment->notice_period = 'Not exist';
                    } else {
                        $attachment->notice_period = $row->notice_period;
                    }
                    if (empty($row->last_working_day)) {
                        $attachment->last_working_day = '0000-00-00';
                    } else {
                        $attachment->last_working_day = date('Y-m-d', strtotime($row->last_working_day));
                    }
                    if (empty($row->full_final)) {
                        $attachment->full_final = 'Not exist';
                    } else {
                        $attachment->full_final = $row->full_final;
                    }
                    $attachment->user_id = $user->id;
                    $attachment->save();

                    $userRole = new UserRole();
                    $userRole->role_id = convertRole($row->role);
                    $userRole->user_id = $user->id;
                    $userRole->save();
                }
                return 1;
                //return redirect('upload_form');*/
            });
        }
        /* catch (\Exception $e) {
          return $e->getMessage(); */

        \Session::flash('success', ' Employee details uploaded successfully.');

        return redirect()->back();
    }

    public function searchEmployee(Request $request) {
        $string = $request->string;
        $column = $request->column;
        if ($request->button == 'Search') {
            if ($string == '' && $column == '') {
                return redirect()->to('employee-manager');
            } elseif ($column == 'email') {
                $emps = User::with('employee')->where($column, $string)->paginate(20);
            } else {
                $emps = User::whereHas('employee', function ($q) use ($column, $string) {
                            $q->whereRaw($column . " like '%" . $string . "%'");
                        })->with('employee')->paginate(20);
            }

            return view('hrms.employee.show_emp', compact('emps', 'column', 'string'));
        } else {
            if ($column == '') {
                $emps = User::with('employee')->get();
            } elseif ($column == 'email') {
                $emps = User::with('employee')->where($request->column, $request->string)->paginate(20);
            } else {
                $emps = User::whereHas('employee', function ($q) use ($column, $string) {
                            $q->whereRaw($column . " like '%" . $string . "%'");
                        })->with('employee')->get();
            }

            $fileName = 'Employee_Listing_' . rand(1, 1000) . '.xlsx';
            $filePath = storage_path('export/') . $fileName;
            $file = new \SplFileObject($filePath, "a");
            // Add header to csv file.
            $headers = ['id', 'photo', 'code', 'name', 'status', 'gender', 'date_of_birth', 'date_of_joining', 'number', 'qualification', 'emergency_number', 'pan_number', 'father_name', 'current_address', 'permanent_address', 'formalities', 'offer_acceptance', 'probation_period', 'date_of_confirmation', 'department', 'salary', 'account_number', 'bank_name', 'ifsc_code', 'pf_account_number', 'un_number', 'pf_status', 'date_of_resignation', 'notice_period', 'last_working_day', 'full_final', 'user_id', 'created_at', 'updated_at'];
            $file->fputcsv($headers);
            foreach ($emps as $emp) {
                $file->fputcsv([
                    $emp->id,
                    (
                    $emp->employee->photo) ? $emp->employee->photo : 'Not available',
                    $emp->employee->code,
                    $emp->employee->name,
                    $emp->employee->status,
                    $emp->employee->gender,
                    $emp->employee->date_of_birth,
                    $emp->employee->date_of_joining,
                    $emp->employee->number,
                    $emp->employee->qualification,
                    $emp->employee->emergency_number,
                    $emp->employee->pan_number,
                    $emp->employee->father_name,
                    $emp->employee->current_address,
                    $emp->employee->permanent_address,
                    $emp->employee->formalities,
                    $emp->employee->offer_acceptance,
                    $emp->employee->probation_period,
                    $emp->employee->date_of_confirmation,
                    $emp->employee->department_id,
                    $emp->employee->salary,
                    $emp->employee->account_number,
                    $emp->employee->bank_name,
                    $emp->employee->ifsc_code,
                    $emp->employee->pf_account_number,
                    $emp->employee->un_number,
                    $emp->employee->pf_status,
                    $emp->employee->date_of_resignation,
                    $emp->employee->notice_period,
                    $emp->employee->last_working_day,
                    $emp->employee->full_final
                ]);
            }

            return response()->download(storage_path('export/') . $fileName);
        }
    }

    public function showDetails() {
        $emps = User::with('employee')->paginate(15);

        return view('hrms.employee.show_bank_detail', compact('emps'));
    }

    public function updateAccountDetail(Request $request) {
        try {
            $model = Employee::where('id', $request->employee_id)->first();
            $model->bank_name = $request->bank_name;
            $model->account_number = $request->account_number;
            $model->iqama_number = $request->iqama_number;
            $model->ifsc_code = $request->ifsc_code;

            $model->save();
            return json_encode('success');
        } catch (\Exception $e) {
            \Log::info($e->getMessage() . ' on ' . $e->getLine() . ' in ' . $e->getFile());
            return json_encode('failed');
        }
    }

    public function doPromotion() {
        $emps = User::get();
        $roles = Role::get();
        return view('hrms.promotion.add_promotion', compact('emps', 'roles'));
    }

    public function getPromotionData(Request $request) {
        $result = Employee::with('userrole.role')->where('id', $request->employee_id)->first();
        if ($result) {
            $result = ['salary' => $result->salary, 'designation' => $result->userrole->role->name, 'emptype' => $result->employee_type];
        }
        return json_encode(['status' => 'success', 'data' => $result]);
    }

    public function processPromotion(Request $request) {

        $newDesignation = Role::where('id', $request->new_designation)->first();
        $process = Employee::where('id', $request->emp_id)->first();
        $process->salary = $request->new_salary;
        $process->housing_allowance = $request->hra_salary;
        $process->employee_gosi = $request->employee_gosi;
        $process->employer_gosi = $request->employer_gosi;
        $process->save();

        \DB::table('user_roles')->where('user_id', $process->user_id)->update(['role_id' => $request->new_designation]);

        $promotion = new Promotion();
        $promotion->emp_id = $request->emp_id;
        $promotion->old_designation = $request->old_designation;
        $promotion->new_designation = $newDesignation->name;
        $promotion->old_salary = $request->old_salary;
        $promotion->new_salary = $request->new_salary;
        $promotion->date_of_promotion = date_format(date_create($request->date_of_promotion), 'Y-m-d');
        $promotion->save();

        \Session::flash('flash_message', 'Employee successfully Promoted!');
        return redirect()->back();
    }

    public function showPromotion() {
        $promotions = Promotion::with('employee')->paginate(10);
        return view('hrms.promotion.show_promotion', compact('promotions'));
    }

    /**
     * 
     * @param type $basicamount
     * @param type $employeetype
     * @return type
     */
    private function salaryCalculation($basicamount, $employeetype) {
        $resultArray = array();
        $resultArray['housing_allowance'] = $basicamount * .25;
        $resultArray['salary'] = $basicamount;
        $totalSalary = $resultArray['salary'] + $resultArray['housing_allowance'];
        if ($employeetype == 0) {
            $resultArray['employer_gosi'] = ($totalSalary > 0) ? ($totalSalary * .02) : 0;
        } else {
            $employeegosi = ($totalSalary > 0) ? ($totalSalary * .10) : 0;
            $employergosi = ($totalSalary > 0) ? ($totalSalary * .12) : 0;
            $resultArray['employee_gosi'] = $employeegosi;
            $resultArray['employer_gosi'] = $employergosi;
        }
        return $resultArray;
    }

    /**
     * 
     * @param type $id
     * @return type
     */
    public function uploadEmpfiles($id) {
        return view('hrms.employee.employee_uploads');
    }

    /**
     * 
     * @param Request $request
     * @param type $id
     * @return type
     */
    public function saveuploadedFiles(Request $request, $id) {

        if ($request->file('upload_file')) {
            $files = $request->file('upload_file');
            $datetime = date('Y-m-d h:i');
            $insertArray = array();
            $emps = User::where('id', $id)->with('employee')->first();
            $comments = $request->get('description');
            foreach ($files as $uploadedfile) {

                $path_parts = pathinfo($uploadedfile->getClientOriginalName());
                $newfilename = $path_parts['filename'] . "_" . date('Ymdhis') . '.' . $path_parts['extension'];
                $uploadedfile->move(storage_path('Employeedocuments/' . $emps->employee->id), $newfilename);

                $insertArray[] = array("employee_id" => $emps->employee->id,
                    "filename" => $newfilename,
                    "upload_by" => \Auth::user()->employee->id,
                    "upload_at" => $datetime,
                    "comment" => $comments
                );
            }
            if (count($insertArray) > 0) {
                \DB::table('employee_documents')->insert($insertArray); // Query Builder approach
            }
            \Session::flash('success', 'Successfully uploaded documents!!!!');
            return redirect()->back();
        }
    }

    /**
     * 
     * @param type $id
     * @return type
     */
    public function showFileDetails($id) {

        if (\Auth::user()->isAdmin || \Auth::user()->isHR()) {
            $details = \DB::table('employee_documents')->select('employees.name', 'employees.code', 'employee_documents.id', 'employee_documents.filename', 'employee_documents.upload_at', 'employee_documents.comment')->join('employees', 'employees.id', '=', 'employee_documents.employee_id')->orderBy('id', 'desc')->paginate(15);
        } else {
            $emps = User::where('id', $id)->with('employee')->first();
            $details = \DB::table('employee_documents')->select('*')->where('employee_id', $emps->employee->id)->orderBy('id', 'desc')->paginate(15);
        }
        $column = '';
        $string = '';
        $dateFrom = '';
        $dateTo = '';

        return view('hrms.employee.documents-list', compact('details', 'column', 'string', 'dateFrom', 'dateTo', 'id'));
    }

    /**
     * 
     * @param Request $request
     * @param type $id
     * @return type
     */
    public function searchDocuments(Request $request, $id) {
        try {
            $string = $request->string;
            $column = $request->column;
            $dateTo = $request->dateTo;
            $dateFrom = $request->dateFrom;

            $data = ['name' => 'employees.name', 'code' => 'employees.code'];

            if ($request->button == 'Search') {
                /**
                 * First we build a query string which is common in both cases whether we have a condition set or not
                 */
                $details = \DB::table('employee_documents')->select('employees.name', 'employees.code', 'employee_documents.id', 'employee_documents.filename', 'employee_documents.upload_at', 'employee_documents.comment')->join('employees', 'employees.id', '=', 'employee_documents.employee_id')->orderBy('id', 'desc');

                if (!empty($column) && !empty($string) && empty($dateFrom) && empty($dateTo)) {
                    $details = $details->whereRaw($data[$column] . " like '%" . $string . "%' ")->paginate(20);
                } elseif (!empty($dateFrom) && !empty($dateTo) && empty($column) && empty($string)) {
                    $dateTo = date_format(date_create($request->dateTo), 'Y-m-d');
                    $dateFrom = date_format(date_create($request->dateFrom), 'Y-m-d');
                    $details = $details->whereBetween('employee_documents.upload_at', [$dateFrom, $dateTo])->paginate(20);
                } elseif (!empty($column) && !empty($string) && !empty($dateFrom) && !empty($dateTo)) {
                    $dateTo = date_format(date_create($request->dateTo), 'Y-m-d');
                    $dateFrom = date_format(date_create($request->dateFrom), 'Y-m-d');
                    $details = $details->whereRaw($data[$column] . " like '%" . $string . "%'")->whereBetween('employee_documents.upload_at', [$dateFrom, $dateTo])->paginate(20);
                } else {
                    $details = $details->paginate(20);
                }
                $post = 'post';
                return view('hrms.employee.documents-list', compact('details', 'column', 'string', 'dateFrom', 'dateTo', 'post', 'id'));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    public function listDocuments($id) {


        $details = \DB::table('employee_documents')->select('*')->where('employee_id', $id)->orderBy('id', 'desc')->paginate(15);
        
        return view('hrms.employee.individual-documents-list', compact('details', 'id'));
    }

    public function deleteDocument($id) {
        $emp = EmployeeDocuments::find($id);
        $filename = $emp->filename;
        $employeeId = $emp->employee_id;
        try {
            $emp->delete();            
            File::delete(storage_path('Employeedocuments/' . $employeeId).'/'.$filename);
            \Session::flash('flash_message', 'Document successfully deleted!');
        } catch(\Exception $e) {
            \Session::flash('flash_message', 'Some error occured!'); 
        }
        
        return redirect()->route('list-emp-files', ['id' => $employeeId]);
    }

    /**
     * 
     * @return type
     */
    private function getGradeCollection() {
        $gradeArray = array();
        array_push($gradeArray, ['id' => 1, 'title' => 'High management']);
        array_push($gradeArray, ['id' => 2, 'title' => 'Middle management']);
        array_push($gradeArray, ['id' => 3, 'title' => 'Employee']);
        $grades = collect($gradeArray);
        return $grades;
    }
/**
 * 
 * @param type $request
 * @param type $id
 */
    private function uploadEmpdocs($request, $id) {
        $files = $request->file('emp_appointment_doc');
        $datetime = date('Y-m-d h:i');
        $insertArray = array();
        $emps = User::where('id', $id)->with('employee')->first();
        $comments = 'joining documents';
        foreach ($files as $uploadedfile) {

            $path_parts = pathinfo($uploadedfile->getClientOriginalName());
            $newfilename = $path_parts['filename'] . "_" . date('Ymdhis') . '.' . $path_parts['extension'];
            $uploadedfile->move(storage_path('Employeedocuments/' . $emps->employee->id), $newfilename);

            $insertArray[] = array("employee_id" => $emps->employee->id,
                "filename" => $newfilename,
                "upload_by" => \Auth::user()->employee->id,
                "upload_at" => $datetime,
                "comment" => $comments
            );
        }
        if (count($insertArray) > 0) {
                \DB::table('employee_documents')->insert($insertArray); // Query Builder approach
            }
    }
    
    /**
     * 
     * @param type $userId
     * @return type
     */
    
    public function empOverview($userId){
        $details = Employee::where('user_id', $userId)->with('userrole.role','documents','employeeLoans','department','employeeLeaves')->first();
         $leaveTypeId =1;
        $count = EmployeeLeaves::where(['user_id' => $userId, 'leave_type_id' => $leaveTypeId, 'status' => '1'])->get();

        $day = 0;
        foreach ($count as $days) {
            $day += $days->days;
        }
        //calculate total leaves
        $yearlyLeaves = totalLeaves($leaveTypeId);
        $daydifference = Employee::where('user_id', $userId)->select(\DB::raw('DATEDIFF(now(),date_of_joining) as datediff'))->first();
        $totalDays = $daydifference->datediff;
         $totalLeaves = $totalDays * ($yearlyLeaves/365); 
        
        if($totalLeaves > 60) {
          $totalLeaves =60;   
        }
        $remainingLeaves = $totalLeaves - $day;
        
        
        return view('hrms.employee.overview', compact('details','remainingLeaves'));
    }
    /**
     * 
     * @param type $request
     * @param type $empid
     */
    private function leaveBalanceEntry($request, $empid) {
        $joiningDate = date('Y-m-d',strtotime($request->doj)); 
        $periodTo = date('Y-m-d',strtotime($joiningDate . " + 365 day"));
        
        //if exist update else delete
        $existCount = \DB::table('employee_current_year_ticket')->whereYear('period_from', '=', date('Y'))->where('employee_id',$empid)->count();
        if($existCount >0) {
           $insertArray = array(                
                "spouce_ticket_count" =>$request->ticket_spouse,
                "children_ticket_count" => $request->ticket_children
                
            );  
        \DB::table('employee_current_year_ticket')->whereYear('period_from', '>=', date('Y'))->where('employee_id',$empid)->update($insertArray);
        
        
        
        } else {
           //first year
            $insertArray[0] = array("employee_id" => $empid,
                "self_ticket_count" => 1,
                "spouce_ticket_count" =>$request->ticket_spouse ,
                "children_ticket_count" => $request->ticket_children,
                "period_from" => date_format(date_create($request->doj), 'Y-m-d'),
                "period_to" => date('Y-m-d',strtotime($joiningDate . " +1 year"))
            );  
           
      \DB::table('employee_current_year_ticket')->insert($insertArray);  
        }
        
        
        
    }

}
