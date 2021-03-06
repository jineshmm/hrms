@extends('hrms.layouts.base')

@section('content')
        <!-- START CONTENT -->
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
                    <a href=""> Exit-reentry </a>
                </li>
                <li class="breadcrumb-current-item"> Exit-reentry Request </li>
            </ol>
        </div>
    </header>


    <!-- -------------- Content -------------- -->
    <section id="content" class="table-layout animated fadeIn">

        <!-- -------------- Column Center -------------- -->
        <div class="chute chute-center">

            <!-- -------------- Products Status Table -------------- -->
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-success">
                    <div class="panel">
                        <div class="panel-heading">
                            <span class="panel-title hidden-xs"> Exit-reentry Lists </span><br />
                        </div><br />
                        <div class="panel-menu allcp-form theme-primary mtn">
                            <div class="row">
                                {!! Form::open() !!}
                                <div class="col-md-3">
                                    <input type="text" class="field form-control" placeholder="query string" style="height:40px" name="string" value="{{$string}}">
                                </div>
                                <div class="col-md-3">
                                    <label class="field select">
                                        {!! Form::select('column', getLeaveColumns(),$column) !!}
                                        <i class="arrow double"></i>
                                    </label>
                                </div>

                                <div class="col-md-3">
                                    <input type="text" id="datepicker1" class="select2-single form-control"
                                           name="dateFrom" value="{{$dateFrom}}" placeholder="date from"/>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" id="datepicker4" class="select2-single form-control"
                                           name="dateTo" value="{{$dateTo}}" placeholder="date to"/>
                                </div>

                                <div class="col-md-2"><br />
                                    <input type="submit" value="Search" name="button" class="btn btn-primary">
                                </div>

                                <div class="col-md-2"><br />
                                    <input type="submit" value="Export" name="button" class="btn btn-success">
                                </div>
                                {!! Form::close() !!}
                                <div class="col-md-2"><br />
                                    <a href="/exit-entry-list">
                                        <input type="submit" value="Reset" class="btn btn-warning"></a>
                                </div>

                            </div>
                        </div>
                        <div class="panel-body pn">
                            @if(Session::has('flash_message'))
                                <div class="alert alert-success">
                                    {{ Session::get('flash_message') }}
                                </div>
                            @endif

                            @if(count($exitreentrylists))
                            <div class="table-responsive">
                                <table class="table allcp-form theme-warning tc-checkbox-1 fs13">
                                    <thead>
                                    <tr class="bg-light">
                                        <th class="text-center">Id</th>
                                        <th class="text-center">Employee</th>
                                        <th class="text-center">Code</th>
                                        <th class="text-center">Visa amount</th>
                                        <th class="text-center">Visa period</th>
                                        <th class="text-center">Leave start date</th>
                                        <th class="text-center">Created date</th>
                                        <th class="text-center">Updated date</th>
                                        <th class="text-center">Visa</th>
                                        <th class="text-center">Finance status</th>
                                        
                                        <th class="text-center">Request status</th>
                                        
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i =0;?>
                                    @foreach($exitreentrylists as $leave)
                                        <tr>
                                            <td class="text-center">{{$i+=1}}</td>
                                            <td class="text-center">{{ $leave->name}}</td>
                                            <td class="text-center">{{ $leave->code}}</td>
                                            <td class="text-center">{{ $leave->visa_amount}}</td>
                                            <td class="text-center">{{ $leave->period}}</td>
                                            <td class="text-center">{{ getFormattedDate($leave->date_from) }}</td>
                                            <td class="text-center">{{getFormattedDate($leave->created_date)}}</td>
                                            <td class="text-center">{{getFormattedDate($leave->updated_date)}}</td>
                                             <td class="text-center">@if(isset($leave->uploaded_file))
                                                <a href="/downloadleavedocuments/{{$leave->leaveId}}/0">{{$leave->uploaded_file}}</a>
                                                  @endif
                                                
                                           </td>
                                            
                                           
                                            <input type="hidden" value="{!! csrf_token() !!}" id="token">
                                            <td class="text-center">
                                                <div class="btn-group text-right" id="button-{{$leave->expId}}">
                                                    @if($leave->approve_status==0)
                                                        <button type="button"
                                                                class="btn btn-info br2 btn-xs fs12 dropdown-toggle"
                                                                data-toggle="dropdown" aria-expanded="false"> Pending
                                                            <span class="caret ml5"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li>
                                                                <a class="visaClick" data-id="{{$leave->expId}}" data-name="Approve" data-status="1" data-leaveid="{{$leave->leaveId}}" data-approved-by=1>Approve</a>
                                                            </li>
                                                            <li>
                                                                <a class="visaClick" data-id="{{$leave->expId}}" data-name="Reject" data-status="2" data-leaveid="{{$leave->leaveId}}" data-approved-by=1>Reject</a>
                                                            </li>
                                                            <li>
                                                                <a class="visaClick" data-id="{{$leave->expId}}" data-name="Completete" data-status="3"  data-approved-by=1 data-leaveid="{{$leave->leaveId}}">Completed</a>
                                                            </li>
                                                        </ul>
                                                    @elseif($leave->approve_status==1)
                                                      <button type="button"
                                                                class="btn btn-info br2 btn-xs fs12 dropdown-toggle"
                                                                data-toggle="dropdown" aria-expanded="false"> Approved
                                                            <span class="caret ml5"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">

                                                            <li>
                                                                <a class="visaClick" data-id="{{$leave->expId}}" data-name="Completete" data-status="3"  data-approved-by=1 data-leaveid="{{$leave->leaveId}}">Completed</a>
                                                            </li>
                                                        </ul>
                                                    @elseif($leave->approve_status==2)
                                                    <button type="button"
                                                                class="btn btn-success br2 btn-xs fs12"
                                                                aria-expanded="false"><i class="fa fa-check"> Rejected </i>

                                                     </button>
                                                    
                                                    @else
                                                        <button type="button"
                                                                class="btn btn-warning br2 btn-xs fs12"
                                                                aria-expanded="false"> <i class="fa fa-times"> Completed </i>

                                                        </button>
                                                    @endif

                                                </div>
                                            </td>
                                             <td class="text-center">
                                                <div class="btn-group text-right" id="button-hr-{{$leave->expId}}" >
                                                    @php
                                                    $disable = "";
                                                    @endphp
                                                    @if($leave->request_status ==3)
                                                    
                                                    @php
                                                    $disable = "disabled=true";
                                                    @endphp
                                                    @endif
                                                    
                                                    @if($leave->request_status==0 && ( $leave->approve_status==2 || $leave->approve_status==3))
                                                        <button type="button"
                                                                class="btn btn-info br2 btn-xs fs12 dropdown-toggle"
                                                                data-toggle="dropdown" aria-expanded="false" {{$disable}}> Processing
                                                            <span class="caret ml5"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu" >
                                                            
                                                            <li>
                                                                <a class="hrClick"  data-name="Close" data-id="{{$leave->expId}}"  data-status="1" data-leaveid="{{$leave->leaveId}}" >Close</a>
                                                            </li>
                                                        </ul>
                                                     @elseif($leave->approve_status==0 && $leave->request_status==0)
                                                     <button type="button"
                                                                class="btn btn-info br2 btn-xs fs12 dropdown-toggle"
                                                                data-toggle="dropdown" aria-expanded="false" {{$disable}}> Processing
                                                            <span class="caret ml5"></span>
                                                     </button>
                                                    @elseif($leave->approve_status==1 && $leave->request_status==0)
                                                    <button type="button"
                                                                class="btn btn-info br2 btn-xs fs12 dropdown-toggle"
                                                                data-toggle="dropdown" aria-expanded="false" {{$disable}}> Processing
                                                            <span class="caret ml5"></span>
                                                     </button>
                                                    
                                                    @else
                                                        <button type="button"
                                                                class="btn btn-danger br2 btn-xs fs12"
                                                                aria-expanded="false"> <i class="fa fa-times"> Closed </i>

                                                        </button>
                                                    @endif

                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr><td colspan="11">
                                            {!! $exitreentrylists->render() !!}
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                                @else
                                <div class="row text-center">
                                    <h2>No exit re-entry request to display</h2>
                                </div>
                                @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
            </div>
    </section>
    <!-- Notification modal -->

    

    <!-- Modal -->

    
    
    
    <div id="closeModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                 {{ Form::open(array('route' => array('close-visa-request'), 'class' => 'form-horizontal','id'=>'form_request-close','files'=>'true' )) }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Remark</h4>
                </div>
                <div class="modal-body">
                   
<!--                    <textarea id="remark-text" class="form-control" placeholder="Remarks"></textarea>-->
                        <input type="hidden" id="r_id" name="r_id" value="">
                        <input type="hidden" id="leavereq_id" name="leavereq_id" value="">
                       <input type="hidden" id="reqStatusnumber" name="reqStatusnumber" value="">
                       
                       <div class="panel-body pn mv12 allcp-form">
                             <div class="section">
                                        <label for="file1"><h6 > Upload File </h6></label>
                                            <label class="field prepend-icon append-button file">
                                                <span class="button">Choose File</span>
                                                <input type="file" class="gui-file" name="upload_file" id="file1"
                                                       onChange="document.getElementById('uploader1').value = this.value;">
                                                <input type="text" class="gui-input" id="uploader1"
                                                       placeholder="Select File" required>
                                            </label>
                                    </div>
                       </div>
                    <div id="loader" class="hidden text-center">
                        <img src="{{ URL::asset('photos/76.gif') }}" />
                    </div>
                       
                       
                       
                       
                    <div id="close-message" class="hidden">

                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Proceed</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                {!! Form::close() !!}
            </div>

        </div>
    </div>
    
        
    <div class="modal fade" tabindex="-1" role="dialog" id="skip-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div id="modal-header" class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <p> Do you really want to <span id="reqString"></span> request?</p>
                    <input type="hidden" id="req_id">
                    <input type="hidden" id="leave_id">
                    <input type="hidden" id="reqStatus">
                    <div id="success-message" class="hidden">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id='reqestprocess'>Yes</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>


    <!-- /Notification Modal -->
</div>
@endsection