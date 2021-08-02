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
                    <a href=""> Loan </a>
                </li>
                <li class="breadcrumb-current-item"> Apply Loan</li>
            </ol>
        </div>
    </header>
    <!-- -------------- Content -------------- -->
    <section id="content" class="table-layout animated fadeIn">
        <!-- -------------- Column Center -------------- -->
        <div class="chute-affix" data-spy="affix" data-offset-top="200">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">
                    <div class="panel">
                        <div class="panel-heading">
                            <span class="panel-title hidden-xs"> Apply for Loan</span>
                        </div>
                    <div class="text-center" id="show-leave-count"></div>
                        <div class="panel-body pn">
                            <div class="table-responsive">
                                <div class="panel-body p25 pb10">
                                    @if(session('message'))
                                        {{session('message')}}
                                    @endif
                                    @if(Session::has('flash_message'))
                                        <div class="alert alert-success">
                                            {{ session::get('flash_message') }}
                                        </div>
                                    @endif
                                    {!! Form::open(['class' => 'form-horizontal', 'method' => 'post']) !!}

                                     <div class="form-group ">
                                        <label for="date_from" class="col-md-2 control-label"> Date </label>
                                        <div class="col-md-10">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar text-alert pr10"></i>
                                                </div>
                                                <input type="text" id="datepicker1" class="select2-single form-control"
                                                       name="dateFrom" required>
                                            </div>
                                        </div>
                                    
                                    </div>
                                    
                                    <div class="form-group dib_leave_numbers">
                                        <label for="input002" class="col-md-2 control-label"> Amount </label>
                                        <div class="col-md-10">
                                            <input id="amount" name="amount" value="" 
                                                   type="text" size="90" class="select2-single form-control"/>
                                        </div>
                                    </div>
                                    <div class="form-group dib_leave_numbers">
                                        <label for="input002" class="col-md-2 control-label"> Installment number </label>
                                        <div class="col-md-10">
                                           <select class="select2-multiple form-control select-primary leave_type"
                                                    name="installment_number" required>
                                               @for ($i = 1; $i < 13; $i++)
                                                         <option value="{{$i}}">{{$i}}</option>
                                              @endfor
                                               
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-md-2 control-label"> Loan Type </label>
                                        <div class="col-md-10">
                                           
                                            <select class="select2-multiple form-control select-primary"
                                                    name="loan_type" required>
                                                <option value="" selected>Select One</option> 
                                                 @foreach($loanTypes as $loanType)
                                                       
                                                        <option value="{{$loanType->id}}">{{$loanType->title}}</option>
                                                    @endforeach
						
                                            </select>
                                        </div>
                                    </div>


                                 
                                    <div class="form-group">
                                        <label for="input002" class="col-md-2 control-label"> Reason </label>
                                        <div class="col-md-10">
                                            <input type="text" id="textarea1" class="select2-single form-control"
                                                   name="reason" required>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-md-2 control-label"></label>

                                        <div class="col-md-2">

                                                <input type="submit" class="btn btn-bordered btn-info btn-block"
                                                             value="Submit">
                                        </div>
                                        <div class="col-md-2"><a href="/apply-loan" >
                                                <input type="button" class="btn btn-bordered btn-success btn-block" value="Reset"></a></div>

                                    </div>

                                    {!! Form::close() !!}
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
</div>

@endsection