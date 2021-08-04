<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

use App\Http\Requests;
use App\User;
use App\Models\Employee;

class fetchController extends Controller
{
    public function employeeAttendance($employeecode)
    {

        try {
    
    
$client = new Client;
        $request = $client->get('http://dib.fortiddns.com:81/iclock/api/transactions/', [
    'auth' => [
        'admin', 
        'Dpib5588'
    ],
    'query' => [
            'emp_code' => 182,
            'start_time' => '2021-07-01 00:00:00',
            'end_time' => '2021-08-02 00:00:00',
            'page_size' =>100
        ]
]);



 




        $response = $request->getStatusCode();
   if($request->getStatusCode() ==200) {
          $result= json_decode($request->getBody()->getContents(), true);
          $insertArray = array();
          //dd($result);
        if($result['data'] > 0) {
                $createdDate = date('Y-m-d H:i:s');
                foreach($result['data'] as $key =>$punchdata) {
                       
                       $employeedetails = Employee::where('code',$punchdata['emp_code'])->first();
                        $insertArray[$key]['emp_id'] = $employeedetails ->id;
                        $insertArray[$key]['emp_code'] = $punchdata['emp_code'];
                        $insertArray[$key]['punch_time'] = date('Y-m-d H:i:s',strtotime($punchdata['punch_time']));
                        $insertArray[$key]['created_date'] = $createdDate;
                        $insertArray[$key]['is_attendance'] = $punchdata['is_attendance'];
                        $insertArray[$key]['entry_date'] = date('Y-m-d',strtotime($punchdata['punch_time']));

                }
        } 
        //echo  "<pre>";
        // print_r($insertArray);exit;
        if (count($insertArray) >0) {
            \DB::table('employee_daily_punch_details')->insert($insertArray);
        }
        
   }
   


        }
        catch(\Exception $e)
        {
            \Log::info($e->getMessage());
          dd($e->getMessage()); 

// SELECT a.emp_code, a.punch_time, a.login, a.logout
// FROM (
//   SELECT p1.emp_code, p1.punch_time,  
//     (SELECT MIN(punch_time) FROM employee_daily_punch_details as p2 WHERE p2.emp_code=p1.emp_code Group by p2.emp_code) as login, 
//     (SELECT MAX(punch_time) FROM employee_daily_punch_details as p2 WHERE p2.emp_code=p1.emp_code Group by p2.emp_code) as logout  
//   FROM employee_daily_punch_details as p1 WHERE punch_time Between '2021-07-01 00:00:00' AND '2021-08-01 
//   00:00:00' 
// ) a
// GROUP BY a.emp_code, a.punch_time, a.login, a.logout, a.id



select 
    emp_id,
    entry_date, 
    min(punch_time) as FirstIN,
    max(punch_time) as LastOUT,TIMESTAMPDIFF(MINUTE,min(punch_time),max(punch_time))
from employee_daily_punch_details
group by emp_id, entry_date






        }

    }

    
}
