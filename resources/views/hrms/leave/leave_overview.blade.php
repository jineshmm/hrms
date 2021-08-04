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
                    <a href="/total-leave-list"> All leaves </a>
                </li>
                <li class="breadcrumb-current-item"> </li>
            </ol>
        </div>
    </header>


    <section id="content" class="animated fadeIn">
        <div class="row">       

            

            
            <div class="col-md-12 paneltabcontent" id='content_overview' aria-hidden="true" style='display:block'>
            
              <div class="row">

           

            <div class="col-md-10">
                <div class="box box-success">
                    <div class="panel">

                        <div class="panel-heading">
                            <span class="panel-title">Leave Details</span>
                        </div>
                        <div class="panel-body pn pb5">
                            <hr class="short br-lighter">


                            <div class="box-body no-padding">

                                <table class="table">
                                    <tbody>
                                        <tr>
                                        <td style="width: 10px" class="text-center"> </td>
                                        <td><strong>Name</strong><input type="hidden" value="{!! csrf_token() !!}" id="token"></td>
                                        <td>{{ $leave->user->name}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 10px" class="text-center">
                                        </td>
                                        <td><strong>Code</strong></td>
                                        <td>{{$leave->user->employee->code}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 10px" class="text-center">
                                        </td>
                                        <td><strong>Leave type</strong></td>
                                        <td>{{getLeaveType($leave->leave_type_id)}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 10px" class="text-center">
                                        </td>
                                        <td><strong>Start date</strong></td>
                                        <td>{{getFormattedDate($leave->date_from)}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 10px" class="text-center">
                                        </td>
                                        <td><strong>End date</strong></td>
                                        <td>{{getFormattedDate($leave->date_to)}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 10px" class="text-center">
                                        </td>
                                        <td><strong>Days</strong></td>
                                        <td>{{$leave->days}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 10px" class="text-center">
                                        </td>
                                        <td><strong>Exit renetry</strong></td>
                                        <td>{{(isset($leave->exit_reentry_flag) && $leave->exit_reentry_flag ==1) ? 'Yes' : 'N/A'}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 10px" class="text-center">
                                        </td>
                                        <td><strong>Flight ticket</strong></td>
                                        <td>{{(isset($leave->flight_ticket_flag) && $leave->flight_ticket_flag ==1) ? 'Yes' : 'N/A'}}</td>
                                    </tr>
                                    @if($leave->flight_ticket_flag ==1)
                                    <tr>
                                        <td style="width: 10px" class="text-center">
                                        </td>
                                        <td><strong>Self</strong></td>
                                        <td>{{( $leave->self_ticket >0) ? $leave->self_ticket : 1}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 10px" class="text-center">
                                        </td>
                                        <td><strong>Spouse ticket count</strong></td>
                                        <td>{{( $leave->spouse_ticket >0) ? $leave->spouse_ticket : 0}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 10px" class="text-center">
                                        </td>
                                        <td><strong>Children ticket count</strong></td>
                                        <td>{{ ($leave->children_ticket >0)? $leave->children_ticket : 0}}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td style="width: 10px" class="text-center">
                                        </td>
                                        <td><strong>Manager status</strong></td>
                                        <td>
                                                      <div class="btn-group text-right" id="button-{{$leave->id}}">
                                                    @if($leave->manager_approve==0)
                                                        <button type="button"
                                                                class="btn btn-info br2 btn-xs fs12 dropdown-toggle"
                                                                data-toggle="dropdown" aria-expanded="false"> Pending
                                                            <span class="caret ml5"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li>
                                                                <a class="approveClick" data-id="{{$leave->id}}" data-name="approve" data-approved-by=1>Approve</a>
                                                            </li>
                                                            <li>
                                                                <a class="disapproveClick" data-id="{{$leave->id}}" data-name="disapprove" data-approved-by=1>Disapprove</a>
                                                            </li>
                                                        </ul>
                                                    @elseif($leave->manager_approve==1)
                                                        <button type="button"
                                                                class="btn btn-success br2 btn-xs fs12"
                                                                aria-expanded="false"><i class="fa fa-check"> Approved </i>

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
                                    <tr>
                                        <td style="width: 10px" class="text-center">
                                        </td>
                                        <td><strong>HR status</strong></td>
                                        <td>
                                                    
                                          <div class="btn-group text-right" id="button-hr-{{$leave->id}}" >
                                                    @php
                                                    $disable = "";
                                                    @endphp
                                                    @if($leave->manager_approve ==0)
                                                    
                                                    @php
                                                    $disable = "disabled=true";
                                                    @endphp
                                                    @endif
                                                    
                                                    @if($leave->status==0)
                                                        <button type="button"
                                                                class="btn btn-info br2 btn-xs fs12 dropdown-toggle"
                                                                data-toggle="dropdown" aria-expanded="false" {{$disable}}> Pending
                                                            <span class="caret ml5"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu" >
                                                            <li>
                                                                <a class="approveClick" data-id="{{$leave->id}}" data-name="approve" data-approved-by=2>Approve</a>
                                                            </li>
                                                            <li>
                                                                <a class="disapproveClick" data-id="{{$leave->id}}" data-name="disapprove" data-approved-by=2>Disapprove</a>
                                                            </li>
                                                        </ul>
                                                    @elseif($leave->status==1)
                                                        <button type="button"
                                                                class="btn btn-success br2 btn-xs fs12"
                                                                aria-expanded="false"><i class="fa fa-check"> Approved </i>

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
                                    </tbody>
                                </table>


                            </div>
                        </div>

                    </div>

                </div>
            </div>

       

            
           
                    </div>
        </div>


        
        </div>   
        
        
        
      
        
        
            

    </section>
    
</div>
 <div class="modal fade" tabindex="-1" role="dialog" id="notification-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div id="modal-header" class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <p></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- Modal -->
    <div id="remarkModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Remark</h4>
                </div>
                <div class="modal-body">
                        <textarea id="remark-text" class="form-control" placeholder="Remarks"></textarea>
                        <input type="hidden" id="leave_id">
                        <input type="hidden" id="type">
                        <input type="hidden" id="approved_by">
                      <div class="form-group finance_approve">
                        <label for="employee_name">Ticket approve</label>
                         <select class="select2-multiple form-control select-primary"
                                                    name="ticket_flag" id='ticket_flag'>
                                                <option value="0">No</option>  
                                                <option value="1" >Yes</option>
                                                                                              
                                                
                                            </select>
                    </div>   
                        
                     <div class="form-group finance_approve">
                        <label for="employee_name">Exit-reentry</label>
                         <select class="select2-multiple form-control select-primary"
                                                    name="exit_flag" id='exit_flag'>
                                                <option value="0">No</option>  
                                                <option value="1" >Yes</option>                                                                                            
                                            </select>
                    </div> 
                        
                    <div class="form-group finance_approve">
                        <label for="employee_name">Visa period</label>
                         <select class="select2-multiple form-control select-primary"
                                                    name="exit_period" id='exit_period'>
                                                    <option value="0">None</option>
                                                <option value="60">60</option>  
                                                <option value="90" >90</option>
                                                <option value="120" >120</option>
                                                <option value="150" >150</option>
                                                <option value="180" >180</option>
                         </select>
                    </div> 
                        
                             
                        
                        
                        

                    <div id="loader" class="hidden text-center">
                        <img src="{{ URL::asset('photos/76.gif') }}" />
                    </div>
                    <div id="status-message" class="hidden">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="proceed-button">Proceed</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
    
    
    
    <div id="disapproveModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Remark</h4>
                </div>
                <div class="modal-body">
                        <textarea id="remark-text" class="form-control" placeholder="Remarks"></textarea>
                        <input type="hidden" id="leave_id">
                        <input type="hidden" id="type">
                        <input type="hidden" id="approved_by">
  
                    <div id="loader" class="hidden text-center">
                        <img src="{{ URL::asset('photos/76.gif') }}" />
                    </div>
                    <div id="status-message" class="hidden">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="proceed-button">Proceed</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
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

