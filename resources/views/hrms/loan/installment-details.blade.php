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
                <li class="breadcrumb-current-item"> Installments</li>
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
                            <span class="panel-title hidden-xs"> Installment details </span>
                        </div>
                        <div class="panel-body pn">
                           
                            <div class="table-responsive">
                                <table class="table allcp-form theme-warning tc-checkbox-1 fs13">
                                    <thead>
                                    <tr class="bg-light">
                                        <th class="text-center">Id</th>
                                        <th class="text-center">Amount</th>
                                        <th class="text-center">Installment date</th>                                        
                                        <th class="text-center">Status</th>
                                      
                                        <input type="hidden" value="{!! csrf_token() !!}" id="token">
                                        <th class="text-center">Action</th>
                                       
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i =0;?>
                                    @foreach($results as $installment)
                                        <tr>
                                            <td class="text-center">                                               
                                              {{$i+=1}}                                           
                                            </td>
                                            <td class="text-center">{{$installment->amount}}</td>
                                            <td class="text-center">{{getFormattedDate($installment->installment_date)}}</td>
                                            
                                             <td class="text-center">
                                                <div class="btn-group text-right" id="button-{{$installment->id}}">
                                                                                                           
                                                
                                                    @if( $installment->paid_status ==1)
                                                        <button type="button"
                                                                class="btn btn-success br2 btn-xs fs12"
                                                                aria-expanded="false"> <i class="fa fa-check">Paid</i>

                                                        </button>
                                                    @elseif( $installment->skip_status ==1)
                                                        <button type="button"
                                                                class="btn btn-danger br2 btn-xs fs12 warning-color"
                                                                aria-expanded="false"> <i class="fa fa-times">Skipped</i>

                                                        </button>
                                                    @else
                                                        <button type="button"
                                                                class="btn btn-danger br2 btn-xs fs12"
                                                                aria-expanded="false"> <i class="fa fa-times">Unpaid</i>

                                                        </button>
                                                    @endif

                                                </div>
                                            </td>
                                            
                                     

<td class="text-center">
                                                <div class="btn-group text-right" >
                                        
                                                    <button type="button"
                                                                class="btn btn-info br2 btn-xs fs12 dropdown-toggle"
                                                                data-toggle="dropdown" aria-expanded="false"> Actions
                                                            <span class="caret ml5"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            @if( $installment->skip_status ==0)
                                                            <li>
                                                                <a class="paidClick" data-id="{{$installment->id}}" data-name="1" data-approved-by=1>Paid</a>
                                                            </li>
                                                            <li>
                                                                <a class="unpaidClick" data-id="{{$installment->id}}" data-name="0" data-approved-by=1>Unpaid</a>
                                                            </li>
                                                            <li>
                                                                <a class="skipClick" data-id="{{$installment->id}}" data-loan-id ="{{$installment->loan_id}}" data-name="0" data-approved-by=1>Skip</a>
                                                            </li>
                                                           @endif 
                                                        </ul>
                                        
                                                </div>
</td>

                                            
                                        </tr>
                                    @endforeach
                                    <tr>
                                    <td colspan="5"></td> 
                                        {!! $results->render() !!}  
                                      
                                        
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
                        <input type="hidden" id="inst_id">
                        <input type="hidden" id="type">
  
                        

                    <div id="loader" class="hidden text-center">
                        <img src="{{ URL::asset('photos/76.gif') }}" />
                    </div>
                    <div id="status-message" class="hidden">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="approve-button">Proceed</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>


    <!-- /Notification Modal -->
    
    <div class="modal fade" tabindex="-1" role="dialog" id="skip-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div id="modal-header" class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <p> Do you really want to skip installment?</p>
                    <input type="hidden" id="instal_id">
                    <input type="hidden" id="loan_id">
                    
                    <div id="status-message" class="hidden">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" id='skipButton'>Yes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

</div>
@endsection