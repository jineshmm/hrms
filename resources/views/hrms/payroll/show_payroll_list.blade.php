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
                    <a href=""> Payroll </a>
                </li>
                <li class="breadcrumb-current-item"> List</li>
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
                                <span class="panel-title hidden-xs">Payroll List</span>
                            </div>
                            <div class="panel-menu allcp-form theme-primary mtn">
                                <div class="row">
                                    {!! Form::open() !!}
                                    <div class="col-md-3">
                                        <input type="text" class="field form-control" placeholder="query string" style="height:40px" name="string" value="{{$string}}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="field select">
                                            {!! Form::select('column', getTerminationColumns(),$column) !!}
                                            <i class="arrow double"></i>
                                        </label>
                                    </div>

                                    <div class="col-md-3">
                                        <input type="text"  class="select2-single form-control"
                                               name="dateFrom" value="{{$dateFrom}}" placeholder="month"/>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text"  class="select2-single form-control"
                                               name="dateTo" value="{{$dateTo}}" placeholder="Year"/>
                                    </div>

                                    <div class="col-md-2"><br />
                                        <input type="submit" value="Search" name="button" class="btn btn-primary">
                                    </div>

                                    <div class="col-md-2"><br />
                                        <input type="submit" value="Export" name="button" class="btn btn-success">
                                    </div>

                                    {!! Form::close() !!}



                                </div>
                                <div class='row'>
                                    
                                    <div class="col-md-10">
                                        <a href="/payroll-list" style='float:right'>
                                            <input type="submit" value="Reset" class="btn btn-warning"></a>
                                    </div>  
                                    <div class="col-md-2">
                                        <a href="/generate-payroll"><input type="submit" value="Generate payroll" name="button" class="btn btn-success"></a>
                                    </div>
                                </div>
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
                                                <th class="text-center">Employee name</th>
                                                <th class="text-center">Employee Code</th>
                                                <th class="text-center">Salary</th>
                                                <th class="text-center">Loan deduction</th>
                                                <th class="text-center">Leave deduction</th>
                                                <th class="text-center">Net salary</th>
                                                <th class="text-center">Month</th>
                                                <th class="text-center">Year</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 0; ?>
                                            @foreach($payrolls as $payroll)
                                            <tr>
                                                <td class="text-center">{{$i+=1}}</td>
                                                <td class="text-center">{{ $payroll->name }}</td>
                                                <td class="text-center">{{ $payroll->code }}</td>
                                                <td class="text-center">{{ $payroll->salary }}</td>
                                                <td class="text-center"> {{ $payroll->loan_deduction }} </td>
                                                <td class="text-center"> {{ $payroll->leave_deduction }} </td>
                                                <td class="text-center"> {{ $payroll->net_salary  }} </td>
                                                <td class="text-center"> {{ getMonthString($payroll->salary_month)  }} </td>
                                                <td class="text-center"> {{ $payroll->salary_year }} </td>
                                            </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="9">

                                                    {!! $payrolls->render() !!}
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