@extends('hrms.layouts.base')

@section('content')
    <!-- START CONTENT -->
    <input type="hidden" value="{{csrf_token()}}" id="token">
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
                        <a href=""> Employee </a>
                    </li>
                    <li class="breadcrumb-current-item"> Bank Details </li>
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
                                <span class="panel-title hidden-xs"> Bank Detail Listings </span>
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
                                            <th class="text-center">Employee</th>
                                            <th class="text-center">Bank Name</th>
                                            <th class="text-center">Account Number</th>
                                            <th class="text-center">IBAN</th>
                                             <th class="text-center">Iqama</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $i =0;?>
                                        @foreach($emps as $emp)
                                            <tr>
                                                <td class="text-center">{{$i+=1}}</td>
                                                <td class="text-center">{{$emp->name}}</td>
                                                <td class="text-center">{{$emp->employee['bank_name']}}</td>
                                                <td class="text-center">{{$emp->employee['account_number']}}</td>
                                                <td class="text-center">{{$emp->employee['ifsc_code']}}</td>
                                                <td class="text-center">{{$emp->employee['iqama_number']}}</td>
                                                <td class="text-center">
                                                    <div class="btn-group text-right">
                                                        <button type="button"
                                                                class="btn btn-success br2 btn-xs fs12 showModal"
                                                                data-info='{!! $emp  !!}' > Edit
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            {!! $emps->render() !!}
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


    <!-- Modal -->
    <div id="bankModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modal Header</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="employee_name">Employee Name</label>
                        <input type="text" id="employee_name" class="form-control" readonly>
                    </div>

                    <div class="form-group">
                        <label for="bank_name">Bank Name</label>
                        <input type="text" id="bank_name" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="account_number">Account Number</label>
                        <input type="text" id="account_number" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="ifsc_code">IBAN</label>
                        <input type="text" id="ifsc_code" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="iqama_number">Iqama</label>
                        <input type="text" id="iqama_number" class="form-control">
                    </div>
                    <input type="hidden" id="emp_id" class="form-control">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-custom" id="update-bank-account-details">Update</button>
                </div>
            </div>

        </div>
    </div>
@endsection