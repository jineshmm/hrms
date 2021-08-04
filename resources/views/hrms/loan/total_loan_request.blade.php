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
                    <a href=""> Loans </a>
                </li>
                <li class="breadcrumb-current-item"> Total Loan Requests </li>
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
                            <span class="panel-title hidden-xs"> Total Loan Lists </span><br />
                        </div><br />
                        <div class="panel-menu allcp-form theme-primary mtn">
                            <div class="row">
                                {!! Form::open() !!}
                                <div class="col-md-3">
                                    <input type="text" class="field form-control" placeholder="query string" style="height:40px" name="string" value="{{$string}}">
                                </div>
                                <div class="col-md-3">
                                    <label class="field select">
                                        {!! Form::select('column', getLoanColumns(),$column) !!}
                                        <i class="arrow double"></i>
                                    </label>
                                </div>

                           

                                <div class="col-md-2"><br />
                                    <input type="submit" value="Search" name="button" class="btn btn-primary">
                                </div>


                                {!! Form::close() !!}
                                <div class="col-md-2"><br />
                                    <a href="/total-loan-list" >
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

                            @if(count($loans))
                            <div class="table-responsive">
                                <table class="table allcp-form theme-warning tc-checkbox-1 fs13">
                                    <thead>
                                    <tr class="bg-light">
                                        <th class="text-center">Id</th>
                                        <th class="text-center">Employee</th>
                                        <th class="text-center">Code</th>
                                        <th class="text-center">Request date</th>
                                        <th class="text-center">Amount</th>
                                        <th class="text-center">Remarks</th>
                                        <th class="text-center">Manager Status</th>
                                        <th class="text-center">Finance Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i =0;?>
                                    @foreach($loans as $loan)
                                        <tr>
                                            <td class="text-center">{{$i+=1}}</td>
                                            <td class="text-center">{{(isset($post))? $loan->name : $loan->user->name}}</td>
                                            <td class="text-center">{{(isset($post))? $loan->code : $loan->user->employee->code}}</td>                                           
                                            <td class="text-center">{{getFormattedDate($loan->created_at)}}</td>                                           
                                            <td class="text-center">{{$loan->amount}}</td>                                            
                                            <td class="text-center" id="remark-{{$loan->id}}">{{(isset($loan->remarks)) ? $loan->remarks : 'N/A'}}</td>
                                            <input type="hidden" value="{!! csrf_token() !!}" id="token">
                                           
                                            <td class="text-center">
                                                <div class="btn-group text-right" id="button-{{$loan->id}}">
                                                    @if($loan->manager_approve_status==0)
                                                        <button type="button"
                                                                class="btn btn-info br2 btn-xs fs12 dropdown-toggle"
                                                                data-toggle="dropdown" aria-expanded="false"> Pending
                                                            <span class="caret ml5"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li>
                                                                <a class="loanapproveClick" data-id="{{$loan->id}}" data-name="approve" data-approved-by=1>Approve</a>
                                                            </li>
                                                            <li>
                                                                <a class="loandisapproveClick" data-id="{{$loan->id}}" data-name="disapprove" data-approved-by=1>Disapprove</a>
                                                            </li>
                                                        </ul>
                                                    @elseif($loan->manager_approve_status==1)
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
                                             <td class="text-center">
                                                <div class="btn-group text-right" id="button-hr-{{$loan->id}}" >
                                                    @php
                                                    $disable = "";
                                                    @endphp
                                                    @if($loan->manager_approve_status ==0)
                                                    
                                                    @php
                                                    $disable = "disabled=true";
                                                    @endphp
                                                    @endif
                                                    
                                                    @if($loan->finance_approve_status==0)
                                                        <button type="button"
                                                                class="btn btn-info br2 btn-xs fs12 dropdown-toggle"
                                                                data-toggle="dropdown" aria-expanded="false" {{$disable}}> Pending
                                                            <span class="caret ml5"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu" >
                                                            <li>
                                                                <a class="loanapproveClick" data-id="{{$loan->id}}" data-name="approve" data-approved-by=2>Approve</a>
                                                            </li>
                                                            <li>
                                                                <a class="loandisapproveClick" data-id="{{$loan->id}}" data-name="disapprove" data-approved-by=2>Disapprove</a>
                                                            </li>
                                                        </ul>
                                                    @elseif($loan->finance_approve_status==1)
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
                                    @endforeach
                                    <tr><td colspan="10">
                                            {!! $loans->render() !!}
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                                @else
                                <div class="row text-center">
                                    <h2>No loan to show</h2>
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
    <div id="approveModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Remark</h4>
                </div>
                <div class="modal-body">
                    <p>
                        <textarea id="remark-text" class="form-control" placeholder="Remarks"></textarea>
                        <input type="hidden" id="loan_id">
                        <input type="hidden" id="type">
                        <input type="hidden" id="approved_by">

                    <div id="loader" class="hidden text-center">
                        <img src="{{ URL::asset('photos/76.gif') }}" />
                    </div>
                    <div id="status-message" class="hidden">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="loan_proceed-button">Proceed</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>


    <!-- /Notification Modal -->
</div>
@endsection