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
                <li class="breadcrumb-link">
                    <a href=""> Leaves </a>
                </li>
                <li class="breadcrumb-current-item"> Total Leave Requests </li>
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
                            <span class="panel-title hidden-xs"> Total Leave Lists </span><br />
                        </div><br />
                        <div class="panel-menu allcp-form theme-primary mtn">
                            <div class="row">
                                <?php echo Form::open(); ?>

                                <div class="col-md-3">
                                    <input type="text" class="field form-control" placeholder="query string" style="height:40px" name="string" value="<?php echo e($string); ?>">
                                </div>
                                <div class="col-md-3">
                                    <label class="field select">
                                        <?php echo Form::select('column', getLeaveColumns(),$column); ?>

                                        <i class="arrow double"></i>
                                    </label>
                                </div>

                                <div class="col-md-3">
                                    <input type="text" id="datepicker1" class="select2-single form-control"
                                           name="dateFrom" value="<?php echo e($dateFrom); ?>" placeholder="date from"/>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" id="datepicker4" class="select2-single form-control"
                                           name="dateTo" value="<?php echo e($dateTo); ?>" placeholder="date to"/>
                                </div>

                                <div class="col-md-2"><br />
                                    <input type="submit" value="Search" name="button" class="btn btn-primary">
                                </div>

                                <div class="col-md-2"><br />
                                    <input type="submit" value="Export" name="button" class="btn btn-success">
                                </div>
                                <?php echo Form::close(); ?>

                                <div class="col-md-2"><br />
                                    <a href="/total-leave-list">
                                        <input type="submit" value="Reset" class="btn btn-warning"></a>
                                </div>

                            </div>
                        </div>
                        <div class="panel-body pn">
                            <?php if(Session::has('flash_message')): ?>
                                <div class="alert alert-success">
                                    <?php echo e(Session::get('flash_message')); ?>

                                </div>
                            <?php endif; ?>

                            <?php if(count($leaves)): ?>
                            <div class="table-responsive">
                                <table class="table allcp-form theme-warning tc-checkbox-1 fs13">
                                    <thead>
                                    <tr class="bg-light">
                                        <th class="text-center">Id</th>
                                        <th class="text-center">Employee</th>
                                        <th class="text-center">Code</th>
                                        <th class="text-center">Leave Type</th>
                                        <th class="text-center">Date From</th>
                                        <th class="text-center">Date To</th>
                                        <th class="text-center">Days</th>
                                        <th class="text-center">Remarks</th>
                                        <th class="text-center">Exit re-entry</th>
                                        <th class="text-center">Flight ticket</th>
                                        <th class="text-center">Manager Status</th>
                                        <th class="text-center">HR Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i =0;?>
                                    <?php foreach($leaves as $leave): ?>
                                        <tr>
                                            <td class="text-center"><a href='<?php echo e(route('leave-overview',$leave->id)); ?>'><?php echo e($i+=1); ?></a></td>
                                            <td class="text-center"><?php echo e((isset($post))? $leave->name : $leave->user->name); ?></td>
                                            <td class="text-center"><?php echo e((isset($post))? $leave->code : $leave->user->employee->code); ?></td>
                                            <td class="text-center"><?php echo e((isset($post))? $leave->leave_type : getLeaveType($leave->leave_type_id)); ?></td>
                                            <td class="text-center"><?php echo e(getFormattedDate($leave->date_from)); ?></td>
                                            <td class="text-center"><?php echo e(getFormattedDate($leave->date_to)); ?></td>
                                            <td class="text-center"><?php echo e($leave->days); ?></td>
                                            
                                            <td class="text-center" id="remark-<?php echo e($leave->id); ?>"><?php echo e((isset($leave->remarks)) ? $leave->remarks : 'N/A'); ?></td>
                                            <td class="text-center"><?php echo e((isset($leave->exit_reentry_flag) && $leave->exit_reentry_flag ==1) ? 'Yes' : 'N/A'); ?> </td>
                                            <td class="text-center"><?php echo e((isset($leave->flight_ticket_flag) && $leave->flight_ticket_flag ==1) ? 'Yes' : 'N/A'); ?> </td>
                                            <input type="hidden" value="<?php echo csrf_token(); ?>" id="token">
                                            <td class="text-center">
                                                <div class="btn-group text-right" id="button-<?php echo e($leave->id); ?>">
                                                    <?php if($leave->manager_approve==0): ?>
                                                        <button type="button"
                                                                class="btn btn-info br2 btn-xs fs12 dropdown-toggle"
                                                                data-toggle="dropdown" aria-expanded="false"> Pending
                                                            <span class="caret ml5"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li>
                                                                <a class="approveClick" data-id="<?php echo e($leave->id); ?>" data-name="approve" data-approved-by=1>Approve</a>
                                                            </li>
                                                            <li>
                                                                <a class="disapproveClick" data-id="<?php echo e($leave->id); ?>" data-name="disapprove" data-approved-by=1>Disapprove</a>
                                                            </li>
                                                        </ul>
                                                    <?php elseif($leave->manager_approve==1): ?>
                                                        <button type="button"
                                                                class="btn btn-success br2 btn-xs fs12"
                                                                aria-expanded="false"><i class="fa fa-check"> Approved </i>

                                                        </button>
                                                    <?php else: ?>
                                                        <button type="button"
                                                                class="btn btn-danger br2 btn-xs fs12"
                                                                aria-expanded="false"> <i class="fa fa-times"> Disapproved </i>

                                                        </button>
                                                    <?php endif; ?>

                                                </div>
                                            </td>
                                             <td class="text-center">
                                                <div class="btn-group text-right" id="button-hr-<?php echo e($leave->id); ?>" >
                                                    <?php 
                                                    $disable = "";
                                                     ?>
                                                    <?php if($leave->manager_approve ==0): ?>
                                                    
                                                    <?php 
                                                    $disable = "disabled=true";
                                                     ?>
                                                    <?php endif; ?>
                                                    
                                                    <?php if($leave->status==0): ?>
                                                        <button type="button"
                                                                class="btn btn-info br2 btn-xs fs12 dropdown-toggle"
                                                                data-toggle="dropdown" aria-expanded="false" <?php echo e($disable); ?>> Pending
                                                            <span class="caret ml5"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu" >
                                                            <li>
                                                                <a class="approveClick" data-id="<?php echo e($leave->id); ?>" data-name="approve" data-approved-by=2>Approve</a>
                                                            </li>
                                                            <li>
                                                                <a class="disapproveClick" data-id="<?php echo e($leave->id); ?>" data-name="disapprove" data-approved-by=2>Disapprove</a>
                                                            </li>
                                                        </ul>
                                                    <?php elseif($leave->status==1): ?>
                                                        <button type="button"
                                                                class="btn btn-success br2 btn-xs fs12"
                                                                aria-expanded="false"><i class="fa fa-check"> Approved </i>

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
                                    <tr><td colspan="12">
                                            <?php echo $leaves->render(); ?>

                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                                <?php else: ?>
                                <div class="row text-center">
                                    <h2>No leaves to show</h2>
                                </div>
                                <?php endif; ?>
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
                        <input type="hidden" id="leave_id">
                        <input type="hidden" id="type">
                        <input type="hidden" id="approved_by">
                      <div class="form-group finance_approve">
                        <label for="employee_name">Ticket approve</label>
                         <select class="select2-multiple form-control select-primary"
                                                    name="ticket_flag" id='ticket_flag'>
                                                <option value="0">No</option>  
                                                <option value="1" >Yes</option>
                                                                                              
                                                
                                            </select>
                    </div>   
                        
                     <div class="form-group finance_approve">
                        <label for="employee_name">Exit-reentry</label>
                         <select class="select2-multiple form-control select-primary"
                                                    name="exit_flag" id='exit_flag'>
                                                <option value="0">No</option>  
                                                <option value="1" >Yes</option>                                                                                            
                                            </select>
                    </div> 
                        
                    <div class="form-group finance_approve">
                        <label for="employee_name">Visa period</label>
                         <select class="select2-multiple form-control select-primary"
                                                    name="exit_period" id='exit_period'>
                                                    <option value="0">None</option>
                                                <option value="60">60</option>  
                                                <option value="90" >90</option>
                                                <option value="120" >120</option>
                                                <option value="150" >150</option>
                                                <option value="180" >180</option>
                         </select>
                    </div> 
                        

                    <div id="loader" class="hidden text-center">
                        <img src="<?php echo e(URL::asset('photos/76.gif')); ?>" />
                    </div>
                    <div id="status-message" class="hidden">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="proceed-button">Proceed</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
    
    
    
    <div id="disapproveModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Remark</h4>
                </div>
                <div class="modal-body">
                        <textarea id="remark-text" class="form-control" placeholder="Remarks"></textarea>
                        <input type="hidden" id="leave_id">
                        <input type="hidden" id="type">
                        <input type="hidden" id="approved_by">
  
                    <div id="loader" class="hidden text-center">
                        <img src="<?php echo e(URL::asset('photos/76.gif')); ?>" />
                    </div>
                    <div id="status-message" class="hidden">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="proceed-button">Proceed</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>


    <!-- /Notification Modal -->
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('hrms.layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>