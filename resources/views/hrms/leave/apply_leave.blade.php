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
                    <a href=""> Leave </a>
                </li>
                <li class="breadcrumb-current-item"> Apply Leave</li>
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
                            <span class="panel-title hidden-xs"> Apply for Leave</span>
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
                                        <label for="date_from" class="col-md-2 control-label"> Date <span class='dib_from_label'>From</span> </label>
                                        <div class="col-md-3">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar text-alert pr10"></i>
                                                </div>
                                                <input type="text" id="datepicker1" class="select2-single form-control"
                                                       name="dateFrom" required>
                                            </div>
                                        </div>
                                        <label for="date_to" class="col-md-2 control-label dib_leave_date"> Date To </label>
                                        <div class="col-md-3 dib_leave_date">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar text-alert pr10"></i>
                                                </div>
                                                <input type="text" id="datepicker4" class="select2-single form-control"
                                                       name="dateTo" required>
                                            </div>

                                        </div>
                                    </div>
                                             <div class="form-group">
                                        <label class="col-md-2 control-label"> Leave Type </label>
                                        <div class="col-md-10">
                                            <input type="hidden" value="{!! csrf_token() !!}" id="token">
                                            <input type="hidden" value="{{\Auth::user()->id}}" id="user_id">
                                            <select class="select2-multiple form-control select-primary leave_type leave_change"
                                                    name="leave_type" required>
                                                <option value="" selected>Select One</option>
                                                @foreach($leaves as $leave)
                                                    <option value="{{$leave->id}}">{{$leave->leave_type}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    <div class="form-group dib_leave_time">
                                        <label for="time_from" class=" col-md-2 control-label  "> Time From </label>
                                        <div class="col-md-3">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="imoon imoon-clock text-alert pr10"></i>
                                                </div>
                                                <input type="text" id="timepicker1" class="select2-single form-control" value="9:30"
                                                       name="time_from" required>
                                            </div>
                                        </div>
                                        <label for="time_to" class="col-md-2 control-label"> Time To </label>
                                        <div class="col-md-3">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="imoon imoon-clock text-alert pr10"></i>
                                                </div>
                                                <input type="text" id="timepicker4" class="select2-single form-control" value="18:00"
                                                       name="time_to" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group dib_leave_numbers">
                                        <label for="input002" class="col-md-2 control-label"> Days </label>
                                        <div class="col-md-10">
                                            <input id="total_days" name="number_of_days" value="" readonly="readonly"
                                                   type="text" size="90" class="select2-single form-control"/>
                                        </div>
                                    </div>
                                    
                                      <div class="form-group dib_leave_numbers">
                                        <label for="input002" class="col-md-2 control-label"> Exit re-entry visa</label>
                                       
                                          <div class="col-md-10">
                                            
                                            <select class="select2-multiple form-control select-primary"
                                                    name="visa_flag">
                                                
                                                <option value="0">No</option>  
                                                <option value="1" >Yes</option>
                                                
                                            </select>
                                        </div>
                                    </div>
                                    
                               <div class="form-group dib_leave_numbers">
                                        <label for="input002" class="col-md-2 control-label"> Flight ticket</label>
                                       
                                          <div class="col-md-10">
                                           
                                            <select class="select2-multiple form-control select-primary"
                                                    name="ticket_flag">
                                                <option value="0">No</option>  
                                                <option value="1" >Yes</option>
                                                                                              
                                                
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row dib_ticket_numbers" style="margin-left:15%">
                                            <div class="form-group  col-md-4" style="width:180px">
                                             <label for="input002" class="col-md-2 control-label"> Self</label>

                                               <div class="col-md-10">

                                                 <input type='number' class="select2-single form-control" name='ticket_self' value='1' max='1' disabled min="0"/>
                                             </div>
                                         </div>
                                            <div class="form-group col-md-4" style="width:180px">
                                             <label for="input002" class="col-md-2 control-label"> Spouse</label>

                                               <div class="col-md-10">

                                                   <input type='number' class="select2-single form-control" name='ticket_spouse' value='0' max='5' min="0"/>
                                             </div>
                                         </div>
                                            <div class="form-group col-md-4" style="width:180px">
                                             <label for="input002" class="col-md-2 control-label"> Children</label>

                                               <div class="col-md-10">

                                                 <input type='number' class="select2-single form-control" name='ticket_children' value='0' max='4' min="0"/>
                                             </div>
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
                                        <div class="col-md-2"><a href="/apply-leave" >
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
 @section('pagescript') 
<script>
$(function(){

 
    $(document).off('click','.leave_change');
    $(document).on('click','.leave_change',function(){
         $(".dib_leave_date").show();
         $(".dib_leave_time").show();         
         $(".dib_from_label").show();
         $("#datepicker4").attr('disabled',false);
         $(".dib_leave_numbers").show();
         if($(this).val() == 1) {
          $(".dib_leave_date").show();
          $(".dib_leave_time").hide();
          $(".dib_from_label").show();
          $(".dib_leave_numbers").show();
         } else if($(this).val() == 2) {
           $("#datepicker4").attr('disabled',true);
           $(".dib_leave_time").show();
           $(".dib_from_label").hide();
           $(".dib_leave_numbers").hide();
         } else {
           $(".dib_leave_date").show(); 
           $("#datepicker4").attr('disabled',false);
           $(".dib_leave_time").hide();
           $(".dib_from_label").show();
           $(".dib_leave_numbers").show();
         }
         
         
         
     });
  
  
   
  
  

});
</script>
@endsection
@endsection