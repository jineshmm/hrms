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
                    <a href=""> Reports </a>
                </li>
                <li class="breadcrumb-current-item"> Gosi list</li>
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
                                <span class="panel-title hidden-xs">Gosi List</span>
                            </div>
                            <div class="panel-menu allcp-form theme-primary mtn">
                                <div class="row">
                                    {!! Form::open() !!}
                                    <div class="col-md-3">
                                        <input type="text" class="field form-control" placeholder="query string" style="height:40px" name="string" value="{{$string}}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="field select">
                                            {!! Form::select('column', getGosireportColumns(),$column) !!}
                                            <i class="arrow double"></i>
                                        </label>
                                    </div>

                                    <div class="col-md-3">
                                        <label class="field select">
                                            {!! Form::select('dateFrom', [''=>'Select month']+getMonthlist(),$dateFrom) !!}

                                            <i class="arrow double"></i>
                                        </label>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="field select">
                                            {!! Form::select('dateTo',[''=>'Select month']+ getMonthlist(),$dateTo) !!}
                                            <i class="arrow double"></i>
                                        </label>
                                    </div>

                                    <div class="col-md-2"><br />
                                        <input type="submit" value="Search" name="button" class="btn btn-primary">
                                    </div>

                                    <div class="col-md-2"><br />
                                        <input type="submit" value="Export" name="button" class="btn btn-success">
                                    </div>
                                    {!! Form::close() !!}
                                    <div class="col-md-2"><br />
                                        <a href="/gosi-report">
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
                                {!! Form::open(['class' => 'form-horizontal']) !!}
                                <div class="table-responsive">
                                    <table class="table allcp-form theme-warning tc-checkbox-1 fs13">
                                        <thead>
                                            <tr class="bg-light">
                                                <th class="text-center">Id</th>
                                                <th class="text-center">Employee name</th>
                                                <th class="text-center">Employee Code</th>
                                                <th class="text-center">Salary</th>
                                                <th class="text-center">HRA</th>
                                                <th class="text-center">Employee gosi</th>
                                                <th class="text-center">Employer gosi</th>
                                                <th class="text-center">Month</th>
                                                <th class="text-center">Year</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 0; ?>
                                            @foreach($gosidetails as $gosi)
                                            <tr>
                                                <td class="text-center">{{$i+=1}}</td>
                                                <td class="text-center">{{ $gosi->name }}</td>
                                                <td class="text-center">{{ $gosi->code }}</td>
                                                <td class="text-center">{{  number_format($gosi->salary,2) }}</td>
                                                <td class="text-center">{{  number_format($gosi->hra,2) }}</td>
                                                <td class="text-center">{{ number_format($gosi->gosi,2) }}</td>
                                                <td class="text-center">{{ number_format($gosi->employer_gosi,2) }}</td>
                                                <td class="text-center"> {{ getMonthString($gosi->salary_month)  }} </td>
                                                <td class="text-center"> {{ $gosi->salary_year }} </td>

                                            </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="8">

                                                    {!! $gosidetails->render() !!}
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