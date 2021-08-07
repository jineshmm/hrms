<?php

namespace App\Console\Commands;

use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

use App\Http\Requests;
use App\User;


class AttendanceFetch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Dailypunch:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch the daily punch details from the bio metric database';


    /**
     * Wish constructor.
     * @param Mailer $mailer
     */
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $dateToday = date('Y-m-d');
        $emps = \App\Models\Employee::with('user')->get();


   
$newDate_start = date_create(date("Y-m-d")."00:01:00");
$newDate_end = date_create(date("Y-m-d")."23:59:00");

$createdDate = date('Y-m-d H:i:s');
$insertArray = array();
$i=0;
try {
        foreach($emps as $emp)
        {
            
    
    
$client = new Client;
        $request = $client->get('http://dib.fortiddns.com:81/iclock/api/transactions/', [
    'auth' => [
        'admin', 
        'Dpib5588'
    ],
    'query' => [
            'emp_code' => $emp->code,
            'start_time' => date_format($newDate_start,'Y-m-d H:i'),
            'end_time' => date_format($newDate_end,'Y-m-d H:i'),
            'page_size' =>100
        ]
]);


        $response = $request->getStatusCode();
   if($request->getStatusCode() ==200) {
          $result= json_decode($request->getBody()->getContents(), true);
          

        if($result['count'] > 0) {
              dd($result['data']);  
                foreach($result['data'] as $punchdata) {
                       
                  
                        $insertArray[$i]['emp_id'] = $emp->id;
                        $insertArray[$i]['emp_code'] = $punchdata['emp_code'];
                        $insertArray[$i]['punch_time'] = date('Y-m-d H:i:s',strtotime($punchdata['punch_time']));
                        $insertArray[$i]['created_date'] = $createdDate;
                        $insertArray[$i]['is_attendance'] = $punchdata['is_attendance'];
                        $insertArray[$i]['entry_date'] = date('Y-m-d',strtotime($punchdata['punch_time']));
                        $i++;

                }
        } 

        
        
   }


        }
        if (count($insertArray) >0) {
            DB::table('employee_daily_punch_details')->insert($insertArray);
            //dd($insertArray);
        }

}
        catch(\Exception $e)
        {
            \Log::info($e->getMessage());
          dd($e->getMessage()); 


        }



    }
}
