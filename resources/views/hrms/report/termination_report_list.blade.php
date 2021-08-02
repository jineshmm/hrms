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
                <li class="breadcrumb-current-item"> Termination list</li>
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
                            <span class="panel-title hidden-xs">Termination List</span>
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
                                    <a href="/termination-report">
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
                                        <th class="text-center">Joining date</th>
                                        <th class="text-center">Resignation date</th>
                                     
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i =0;?>
                                    @foreach($terminations as $termination)
                                        <tr>
                                            <td class="text-center">{{$i+=1}}</td>
                                            <td class="text-center">{{ $termination->name }}</td>
                                            <td class="text-center">{{ $termination->code }}</td>
                                            <td class="text-center">{{ getFormattedDate($termination->date_of_joining) }}</td>
                                            <td class="text-center"> {{ getFormattedDate($termination->date_of_resignation) }} </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="5">
                                            
                                            {!! $terminations->render() !!}
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