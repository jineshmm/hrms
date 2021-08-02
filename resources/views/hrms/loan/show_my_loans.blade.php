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
                <li class="breadcrumb-current-item"> My Loan List</li>
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
                            <span class="panel-title hidden-xs"> My Loan Lists </span>
                        </div>
                        <div class="panel-body pn">
                            @if(Session::has('flash_message'))
                                <div class="alert alert-success">
                                    {{ Session::get('flash_message') }}
                                </div>
                            @endif
                            {!! Form::open(['class' => 'form-horizontal']) !!}
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
                                    @foreach($loans as $loan)
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
                                    <tr>
                                        <td colspan="6">
                                          {!! $loans->render() !!}  
                                        </td>
                                        
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
            </div>
    </section>

</div>
@endsection