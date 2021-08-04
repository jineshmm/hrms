@extends('hrms.layouts.base')

@section('content')

<div class="content">
 <header id="topbar" class="alt">
        <div class="topbar-left">
            <ol class="breadcrumb">
                <li class="breadcrumb-icon">
                    <a href="/dashboard">
                        <span class="fa fa-home"></span>
                    </a>
                </li>
                <li class="breadcrumb-active">
                    <a href="/dashboard"> Dashboard </a>
                </li>
                <li class="breadcrumb-link">
                    <a href=""> Employees </a>
                </li>
                <li class="breadcrumb-current-item"> {{ (isset($details->name))? ucfirst($details->name):''  }}</li>
            </ol>
        </div>
    </header>


    <section id="content" class="animated fadeIn">
        <div class="row">       
<div class="col-md-12 card">
        
        
        <ul class="nav nav-tabs policytab" role="tablist" id="policytab">
                                <li id="tab_overview" class="nav-item active" > <a class="nav-link active" data-toggle="tab" href="#content_overview" role="tab" aria-selected="true"> <span class="hidden-xs-down">Profile</span></a> </li>
                                
                                <li id="tab_document" class="nav-item" > <a class="nav-link" data-toggle="tab" href="#content_document" role="tab" aria-selected="false"> <span class="hidden-xs-down">Documents</span></a> </li>
                                
                                <li id="tab_leaves" class="nav-item" > <a class="nav-link" data-toggle="tab" href="#content_leaves" role="tab" aria-selected="false"> <span class="hidden-xs-down">Leaves </span></a> </li>
                                <li id="tab_attendance" class="nav-item" > <a class="nav-link" data-toggle="tab" href="#content_attendance" role="tab" aria-selected="false"> <span class="hidden-xs-down">Attendance</span></a> </li>
                                <li id="tab_loan" class="nav-item" > <a class="nav-link" data-toggle="tab" href="#content_loan" role="tab" aria-selected="false"> <span class="hidden-xs-down">Loan </span></a> </li>
                                
                                
        </ul>
        

    </div>
            
<!--       ****************************************************     OVERVIEW TAB CONTENT    ******************************************************         -->
            
            <div class="col-md-12 paneltabcontent" id='content_overview' aria-hidden="true" style='display:block'>
            
              <div class="row">

            <div class="col-md-6">
                <div class="box box-success">
                    <div class="panel">
                        <div class="panel-heading text-center">
                            <span class="panel-title">{{ (isset($details->name))? ucfirst($details->name):''  }}</span>
                        </div>
                        <div class="panel-body pn pb5 text-center">
                            <hr class="short br-lighter">
                            <img src="{{($details->photo) ? "/photos/".$details->photo : '/assets/img/avatars/profile_pic.png'}}" width="80px" height="80px" class="img-circle img-thumbnail" alt="User Image">

                        </div>
                        <p class="text-center no-margin">{{ (isset($details->userrole->role))? $details->userrole->role->name:''}}</p>
                        <p class="small text-center no-margin"><span class="text-muted">Department:</span> {{$details->department->title}}</p>
                        <p class="small text-center no-margin"><span class="text-muted">Employee ID:</span> {{$details->code}}</p>
                         <p class="small text-center no-margin"><span class="text-muted">National/Iqama ID:</span> {{$details->iqama_number}}</p>


                    </div>
                </div>

                <div class="box box-success">
                    <div class="panel">
                        <div class="panel-heading">
                            <span class="panel-title">Bank Details</span>
                        </div>
                        <div class="panel-body pn pb5">
                            <hr class="short br-lighter">

                            <div class="box-body no-padding">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td style="width: 10px" class="text-center"><i class="fa fa-credit-card"></i></td>
                                        <td><strong>Account Number</strong></td>
                                        <td>{{$details->account_number}}</td>

                                    </tr>
                                    
                                    <tr>
                                        <td style="width: 10px" class="text-center"><i class="fa fa-bank"></i></td>
                                        <td><strong>Bank Name</strong></td>
                                        <td>{{$details->bank_name}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 10px" class="text-center"><i class="fa fa-code"></i></td>
                                        <td><strong>IBAN</strong></td>
                                        <td>{{$details->ifsc_code}}</td>
                                    </tr>
                                   
                                    </tbody>
                                </table>
                            </div>


                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="box box-success">
                    <div class="panel">

                        <div class="panel-heading">
                            <span class="panel-title">Personal Details</span>
                        </div>
                        <div class="panel-body pn pb5">
                            <hr class="short br-lighter">


                            <div class="box-body no-padding">

                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td style="width: 10px" class="text-center"><i class="fa fa-birthday-cake"></i>
                                        </td>
                                        <td><strong>Birthday</strong></td>
                                        <td>{{$details->date_of_birth}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 10px" class="text-center"><i class="fa fa-genderless"></i>
                                        </td>
                                        <td><strong>Gender</strong></td>
                                        <td>{{getGender($details->gender)}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 10px" class="text-center"><i class="fa fa-envelope-o"></i>
                                        </td>
                                        <td><strong>Father's Name</strong></td>
                                        <td>{{$details->father_name}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 10px" class="text-center"><i class="fa fa-mobile-phone"></i>
                                        </td>
                                        <td><strong>Cellphone</strong></td>
                                        <td>{{$details->number}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 10px" class="text-center"><i class="fa fa-map-marker"></i>
                                        </td>
                                        <td><strong>Qualification</strong></td>
                                        <td>{{$details->qualification}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 10px" class="text-center"><i class="fa fa-map-marker"></i>
                                        </td>
                                        <td><strong>Current Address</strong></td>
                                        <td>{{$details->current_address}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 10px" class="text-center"><i class="fa fa-map-marker"></i>
                                        </td>
                                        <td><strong>Permanent Address</strong></td>
                                        <td>{{$details->permanent_address}}</td>
                                    </tr>
                                        <tr>
                                        <td style="width: 10px" class="text-center"><i class="fa fa-map-marker"></i>
                                        </td>
                                        <td><strong>Remaining leaves</strong></td>
                                        <td><b style="color:orangered">{{$remainingLeaves}}</b></td>
                                    </tr>
                                    </tbody>
                                </table>


                            </div>
                        </div>

                    </div>

                </div>
            </div>

       

            
            <div class="col-md-6">
                <div class="box box-success">
                    <div class="panel">
                        <div class="panel-heading">
                            <span class="panel-title">Employment Details</span>
                        </div>
                        <div class="panel-body pn pb5">
                            <hr class="short br-lighter">

                            <div class="box-body no-padding">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td style="width: 10px" class="text-center"><i class="fa fa-key"></i></td>
                                        <td><strong>Employee ID</strong></td>
                                        <td>{{$details->code}}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center"><i class="fa fa-briefcase"></i></td>
                                        <td><strong>Department</strong></td>
                                        <td>{{$details->department->title}}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center"><i class="fa fa-cubes"></i></td>
                                        <td><strong>Designation</strong></td>
                                        <td>{{ (isset($details->userrole->role))? $details->userrole->role->name:'' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center"><i class="fa fa-calendar"></i></td>
                                        <td><strong>Date Joined</strong></td>
                                        <td>{{$details->date_of_joining}}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center"><i class="fa fa-calendar"></i></td>
                                        <td><strong>Date Confirmed</strong></td>
                                        <td>{{$details->date_of_confirmation}}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center"><i class="fa fa-credit-card"></i></td>
                                        <td><strong>Salary</strong></td>
                                        <td>{{$details->salary}}</td>
                                    </tr>
                                    @if($details->spouse_ticket >0)
                                    <tr>
                                        <td class="text-center"><i class="fa fa-credit-card"></i></td>
                                        <td><strong>Spouse ticket</strong></td>
                                        <td>{{$details->spouse_ticket}}</td>
                                    </tr>
                                    @endif
                                    @if($details->children_ticket >0)
                                    <tr>
                                        <td class="text-center"><i class="fa fa-credit-card"></i></td>
                                        <td><strong>Children ticket</strong></td>
                                        <td>{{$details->children_ticket}}</td>
                                    </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
                    </div>
        </div>

<!--       ****************************************************     OVERVIEW TAB CONTENT END    ******************************************************         -->

<!--       ****************************************************     DOCUMENT TAB CONTENT     ******************************************************         -->

        <div class="col-md-12 paneltabcontent" id='content_document' aria-hidden="false" style='display:none'>
            
           @if(count($details->documents)>0)
                            <div class="table-responsive">
                                <table class="table allcp-form theme-warning tc-checkbox-1 fs13">
                                    <thead>
                                      <tr class="bg-light">
                                        <th class="text-center">Id</th>
                                        <th class="text-center">File name</th> 
                                        <th class="text-center">Comments</th>
                                        <th class="text-center">Uploaded Date</th>
                                         
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i =0;?>
                                    @foreach($details->documents as $document)
                                        <tr>
                                            <td class="text-center">{{$i+=1}}</td>
                                            
                                             <td class="text-center"><a href="/downloademployeedocs/{{$document->id }}">{{  $document->filename }} </a></td>
                                            <td class="text-center">{{  $document->comment}}</td>
                                           
                                            <td class="text-center">{{  getFormattedDate($document->upload_at)}}</td>
                                                  
                                             
                                        </tr>
                                    @endforeach
                                  
                                    </tbody>
                                </table>
                            </div>
                                @else
                                <div class="row text-center">
                                    <h2>No document to show</h2>
                                </div>
                                @endif 
            
            
            
            
            
            
        </div>

<!--       ****************************************************     DOCUMENT TAB CONTENT END    ******************************************************         -->
<!--       ****************************************************     LEAVE TAB CONTENT END    ******************************************************         -->
        <div class="col-md-12 paneltabcontent" id='content_leaves' aria-hidden="false" style='display:none'>
               @if(count($details->employeeLeaves)>0)
            <div class="table-responsive">
                                <table class="table allcp-form theme-warning tc-checkbox-1 fs13">
                                    <thead>
                                    <tr class="bg-light">
                                        <th class="text-center">Id</th>
                                        <th class="text-center">Leave Type</th>
                                        <th class="text-center">Date From</th>
                                        <th class="text-center">Date To</th>
                                        <th class="text-center">Days</th>
                                        <th class="text-center">Remarks</th>
                                        <th class="text-center">Exit re-entry</th>
                                        <th class="text-center">Ticket</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i =0;?>
                                    @foreach($details->employeeLeaves as $leave)
                                        <tr>
                                            <td class="text-center">{{$i+=1}}</td>
                                            <td class="text-center">{{getLeaveType($leave->leave_type_id)}}</td>
                                            <td class="text-center">{{getFormattedDate($leave->date_from)}}</td>
                                            <td class="text-center">{{getFormattedDate($leave->date_to)}}</td>
                                            <td class="text-center">{{$leave->days}}</td>
                                            <td class="text-center">{{$leave->remarks}}</td>
                                            <td class="text-center">@if(isset($leave->tickets->ticket_file))
                                                <a href="/downloadleavedocuments/{{$leave->id}}/1">{{$leave->tickets->ticket_file}}</a>
                                                  @endif
                                                
                                           </td>
                                             <td class="text-center">
                                                 @if(isset($leave->exitReentry->uploaded_file))
                                                  <a href="/downloadleavedocuments/{{$leave->id}}/0">{{$leave->exitReentry->uploaded_file}}</a>
                                                  @endif
                                                 </td>
                                            <td class="text-center">
                                                <div class="btn-group text-right">
                                                    @if($leave->status==0)
                                                        <button type="button"
                                                                class="btn btn-info br2 btn-xs fs12"
                                                                aria-expanded="false"> <i class="fa fa-external-link"> Pending </i>

                                                        </button>
                                                    @elseif($leave->status==1)
                                                        <button type="button"
                                                                class="btn btn-success br2 btn-xs fs12"
                                                                aria-expanded="false"> <i class="fa fa-check"> Approved </i>

                                                        </button>
                                                    @else
                                                        <button type="button"
                                                                class="btn btn-danger br2 btn-xs fs12"
                                                                aria-expanded="false"> <i class="fa fa-times"> Disapproved </i>

                                                        </button>
                                                    @endif

                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                  
                                    </tbody>
                                </table>
                            </div> 
                @else
                                <div class="row text-center">
                                    <h2>No leave details to show</h2>
                                </div>
                                @endif
            
        </div>
<!--       ****************************************************     LEAVE TAB CONTENT END    ******************************************************         -->

<!--       ****************************************************     ATTENDANCE TAB CONTENT END    ******************************************************         -->
        <div class="col-md-12 paneltabcontent" id='content_attendance' aria-hidden="false" style='display:none'>
             @if(count($punchingDetails)>0)
            <div class="table-responsive">
                                <table class="table allcp-form theme-warning tc-checkbox-1 fs13">
                                    <thead>
                                    <tr class="bg-light">
                                        <th class="text-center">Id</th>
                                        <th class="text-center">Date</th>
                                        <th class="text-center">Check in</th>
                                        <th class="text-center">Check out</th>
                                        <th class="text-center">Total time</th>
                                        
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i =0;?>
                                    @foreach($punchingDetails as $attendance)
                                        <tr>
                                            <td class="text-center">{{$i+=1}}</td>
                                            <td class="text-center">{{date('d-m-Y',strtotime($attendance->entry_date))}}</td>
                                            <td class="text-center">{{date('d-m-Y H:i:s',strtotime($attendance->FirstIN))}}</td>
                                            <td class="text-center">{{date('d-m-Y H:i:s',strtotime($attendance->LastOUT))}}</td>
                                            <td class="text-center">{{$attendance->totalTime}}</td>
                                            
                                        </tr>
                                    @endforeach
                                  
                                  
                                    </tbody>
                                </table>
                            </div> 
                @else
                                <div class="row text-center">
                                    <h2>No attendance details to show</h2>
                                </div>
                                @endif
            
        </div>
<!--       ****************************************************     ATTENDANCE TAB CONTENT END    ******************************************************         -->
<!--       ****************************************************     LOAN TAB CONTENT END    ******************************************************         -->
        <div class="col-md-12 paneltabcontent" id='content_loan' aria-hidden="false" style='display:none'>
           @if(count($details->employeeLoans)>0)
            <div class="table-responsive">
                                <table class="table allcp-form theme-warning tc-checkbox-1 fs13">
                                    <thead>
                                    <tr class="bg-light">
                                        <th class="text-center">Id</th>
                                        <th class="text-center">Amount</th>
                                        <th class="text-center">Request Date</th>
                                        <th class="text-center">Loan type</th>                                        
                                        <th class="text-center">Remarks</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i =0;?>
                                    @foreach($details->employeeLoans as $loan)
                                        <tr>
                                            <td class="text-center">
                                               @if($loan->finance_approve_status ==1) 
                                                <a href="/installment-details/{{$loan->id}}">{{$i+=1}}</a>
                                            @else
                                              {{$i+=1}}  
                                            @endif
                                                
                                            </td>
                                            <td class="text-center">{{$loan->amount}}</td>
                                            <td class="text-center">{{getFormattedDate($loan->applied_to)}}</td>
                                            
                                             <td class="text-center">{{getLoanType($loan->loan_type_id)}}</td>
                                              <td class="text-center">{{$loan->reason}}</td>
                                             <td class="text-center">
                                                <div class="btn-group text-right">
                                                    @if($loan->finance_approve_status==0)
                                                        <button type="button"
                                                                class="btn btn-info br2 btn-xs fs12"
                                                                aria-expanded="false"> <i class="fa fa-external-link"> Pending </i>

                                                        </button>
                                                    @elseif($loan->finance_approve_status==1)
                                                        <button type="button"
                                                                class="btn btn-success br2 btn-xs fs12"
                                                                aria-expanded="false"> <i class="fa fa-check"> Approved </i>

                                                        </button>
                                                    @else
                                                        <button type="button"
                                                                class="btn btn-danger br2 btn-xs fs12"
                                                                aria-expanded="false"> <i class="fa fa-times"> Disapproved </i>

                                                        </button>
                                                    @endif

                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                
                                    </tbody>
                                </table>
                            </div>
            @else
                                <div class="row text-center">
                                    <h2>No loan details to show</h2>
                                </div>
                                @endif
            
        </div>
<!--       ****************************************************     LOAN TAB CONTENT END    ******************************************************         -->
        
        </div>   
        
        
        
      
        
        
            

    </section>
</div>

@endsection

  
 @push('styles')
   <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
   <style>
       
       .paneltabcontent {
           
           margin:20px 0px 20px 5px;
           
       }
       
       
   </style>
@endpush

@section('pagescript')

<script type="text/javascript">
$( function() {


//$('#policytab a[data-toggle="tab"]').on("shown.bs.tab", function (e) {
////$('#policytab').find('.active').removeClass('active');
//console.log('tab is show');
////$('#tab_'+seletab+' a[href="#content_'+seletab+'"]').addClass('active');
////$('#tab_'+seletab+' a[href="#tab_'+seletab+'"]').attr('aria-selected',true);
//});

   $('#policytab a[data-toggle="tab"]').click(function(){
     $('#policytab').find('.active').removeClass('active');
     $(".paneltabcontent").css('display','none');
        $id = $(this).attr('href');
        $($id).addClass('active');
        $($id).css('display','block');

            
    });
    
    
    
});
</script>
@endsection

