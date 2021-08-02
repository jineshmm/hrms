<?php $__env->startSection('content'); ?>
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

                <li class="breadcrumb-current-item">Travel expense list</li>
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
                                <span class="panel-title hidden-xs"> Travel expense </span>
                            </div>
                            <div class="panel-body pn">
                                <?php if(Session::has('flash_message')): ?>
                                <div class="alert alert-success">
                                    <?php echo e(Session::get('flash_message')); ?>

                                </div>
                                <?php endif; ?>
                                <?php echo Form::open(['class' => 'form-horizontal']); ?>

                                <div class="table-responsive">
                                    <table class="table allcp-form theme-warning tc-checkbox-1 fs13">
                                        <thead>
                                            <tr class="bg-light">
                                                <th class="text-center">Id</th>
                                                <th class="text-center">Employee name</th>
                                                <th class="text-center">Leave type</th>
                                                <th class="text-center">Date From</th>
                                                <th class="text-center">Date To</th>
                                                <th class="text-center">Remarks</th>
                                                <th class="text-center">Ticket</th>
                                                <th class="text-center">Status</th>

                                        <input type="hidden" value="<?php echo csrf_token(); ?>" id="token">
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 0; ?>
                                            <?php foreach($expenses as $leave): ?>
                                            <tr>
                                                <td class="text-center"><a href="/travel-details/<?php echo e($leave->employeeId); ?>"><?php echo e($i+=1); ?></a></td>
                                                <td class="text-center"><?php echo e($leave->name); ?></td>
                                                <td class="text-center"><?php echo e(getLeaveType($leave->leave_type_id)); ?></td>
                                                <td class="text-center"><?php echo e(getFormattedDate($leave->date_from)); ?></td>
                                                <td class="text-center"><?php echo e(getFormattedDate($leave->date_to)); ?></td>
                                                <td class="text-center" id="remark-<?php echo e($leave->expId); ?>"><?php echo e($leave->remarks); ?></td>
                                                <td class="text-center"><?php if(isset($leave->ticket_file)): ?>
                                                    <a href="/downloadleavedocuments/<?php echo e($leave->leaveId); ?>/1"><?php echo e($leave->ticket_file); ?></a>
                                                    <?php endif; ?>

                                                </td>

                                                <td class="text-center">
                                                    <div class="btn-group text-right" id="button-<?php echo e($leave->expId); ?>">
                                                        <?php if($leave->approved_status	==0): ?>
                                                        <button type="button"
                                                                class="btn btn-info br2 btn-xs fs12 dropdown-toggle"
                                                                data-toggle="dropdown" aria-expanded="false" > Pending
                                                            <span class="caret ml5"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu" >
                                                            <li>
                                                                <a class="approveexpenseClick" data-id="<?php echo e($leave->expId); ?>" data-leaveid="<?php echo e($leave->leaveId); ?>" data-empid='<?php echo e($leave->applieduser); ?>'  data-self='<?php echo e($leave->self_ticket); ?>' data-spouse='<?php echo e($leave->spouse_ticket); ?>' data-child="<?php echo e($leave->children_ticket); ?>" data-name="approve" >Approve</a>
                                                            </li>
                                                            <li>
                                                                <a class="disapproveexpenseClick" data-id="<?php echo e($leave->expId); ?>" data-name="disapprove" >Disapprove</a>
                                                            </li>
                                                        </ul>
                                                        <?php elseif($leave->approved_status==1): ?>
                                                        <button type="button"
                                                                class="btn btn-success br2 btn-xs fs12"
                                                                aria-expanded="false"> <i class="fa fa-check"> Approved </i>

                                                        </button>
                                                        <?php else: ?>
                                                        <button type="button"
                                                                class="btn btn-danger br2 btn-xs fs12"
                                                                aria-expanded="false"> <i class="fa fa-times"> Disapproved </i>

                                                        </button>
                                                        <?php endif; ?>

                                                    </div>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                            <tr>
                                                <td colspan="8"><?php echo $expenses->render(); ?></td>

                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <input type="hidden" value="<?php echo csrf_token(); ?>" id="token">
                                <?php echo Form::close(); ?>

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
                    <input type="hidden" id="exp_id">
                    <input type="hidden" id="type">




                    <div id="loader" class="hidden text-center">
                        <img src="<?php echo e(URL::asset('photos/76.gif')); ?>" />
                    </div>
                    <div id="status-message" class="hidden">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="proceed-button-expense">Proceed</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>



    <div id="closeModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <?php echo e(Form::open(array('route' => array('approve-expense'), 'class' => 'form-horizontal','id'=>'form_request-close','files'=>'true' ))); ?>

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Approval</h4>
                </div>
                <div class="modal-body">
<div class="form-group">
                    <textarea  class="form-control" placeholder="Remarks" name="remarks"></textarea>

                    <input type="hidden" id="leavereq_id" name="leavereq_id" value="">
                    <input type="hidden" id="request_id" name="request_id" value="">
</div>
                    <div class="form-group">
                    <label  class="col-md-6 control-label"> Applied ticket details</label>
                    </div>
                    <div class="row dib_ticket_numbers form-group" >
                            
                        <div class="form-group  col-md-3" style="width:180px">
                                <label for="input002" class="col-md-2 control-label"> Self</label>

                                <div class="col-md-10">

                                    <input type='number' class="select2-single form-control" name='ticket_self' id='ticket_self' value='1' max='1'  min="0" />
                                </div>
                            </div>
                            <div class="form-group col-md-5" style="width:180px">
                                <label for="input002" class="col-md-12 control-label"> Spouse ticket</label>

                                <div class="col-md-10">

                                    <input type='number' class="select2-single form-control" id="ticket_spouse" name='ticket_spouse' value=''  min="0"/>
                                </div>
                            </div>
                            <div class="form-group col-md-4" style="width:180px">
                                <label for="input002" class="col-md-2 control-label"> Children</label>

                                <div class="col-md-10">

                                    <input type='number' class="select2-single form-control" id="ticket_children" name='ticket_children' value=''  min="0"/>
                                </div>
                            </div>

                        </div>
<div class="form-group">
                    <label  class="col-md-6 control-label" style="color:#f5393d"> Available ticket details</label>
                    </div>
                            <div class="row dib_ticket_numbers form-group" >
                            
                        <div class="form-group  col-md-3" style="width:180px">
                                <label for="input002" class="col-md-2 control-label"> Self</label>

                                <div class="col-md-10">

                                    <input type='text' class="select2-single form-control" name='available_ticket_self'  id="available_ticket_self" value='' disabled="disabled"/>
                                </div>
                            </div>
                            <div class="form-group col-md-5" style="width:180px">
                                <label for="input002" class="col-md-12 control-label"> Spouse ticket</label>

                                <div class="col-md-10">

                                    <input type='text' class="select2-single form-control"  name='available_ticket_spouse'  id='available_ticket_spouse' value='' disabled="disabled"/>
                                </div>
                            </div>
                            <div class="form-group col-md-4" style="width:180px">
                                <label for="input002" class="col-md-2 control-label"> Children</label>

                                <div class="col-md-10">

                                    <input type='text' class="select2-single form-control"  name='available_ticket_children' id='available_ticket_children' value='' disabled="disabled"/>
                                </div>
                            </div>

                        </div>

                      
                    
                    <div class="panel-body pn mv12 allcp-form">

                        





                        <div class="section" style='margin-top:40px'>
                            <label for="file1" style='margin-left:20px'><h6 > Upload File </h6></label>
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
                        <img src="<?php echo e(URL::asset('photos/76.gif')); ?>" />
                    </div>




                    <div id="close-message" class="hidden">

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Proceed</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                <?php echo Form::close(); ?>

            </div>

        </div>
    </div>


    <!-- /Notification Modal -->
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('hrms.layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>