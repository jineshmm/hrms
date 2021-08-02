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
                    <a href="/travel-expense"> Travel expense </a>
                </li>
                <li class="breadcrumb-current-item"> Ticket Requests </li>
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
                            <span class="panel-title hidden-xs"> Ticket request </span><br />
                        </div><br />
              
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
                                                                           
                                        <th class="text-center">Date From</th>
                                        <th class="text-center">Date To</th>
                                        <th class="text-center">Days</th>
                                        <th class="text-center">Remarks</th>
                                        <th class="text-center">Exit re-entry</th>
                                        <th class="text-center">Flight ticket</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i =0;?>
                                    <?php foreach($leaves as $leave): ?>
                                        <tr>
                                            <td class="text-center"><?php echo e($i+=1); ?></td>
                                                                                     
                                            <td class="text-center"><?php echo e(getFormattedDate($leave->date_from)); ?></td>
                                            <td class="text-center"><?php echo e(getFormattedDate($leave->date_to)); ?></td>
                                            <td class="text-center"><?php echo e($leave->days); ?></td>                                            
                                            <td class="text-center" id="remark-<?php echo e($leave->id); ?>"><?php echo e((isset($leave->remarks)) ? $leave->remarks : 'N/A'); ?></td>
                                            <td class="text-center"><?php echo e((isset($leave->exit_reentry_flag) && $leave->exit_reentry_flag ==1) ? 'Yes' : 'N/A'); ?> </td>
                                            <td class="text-center"><?php echo e((isset($leave->flight_ticket_flag) && $leave->flight_ticket_flag ==1) ? 'Yes' : 'N/A'); ?> </td>
                                            
                                        </tr>
                                    <?php endforeach; ?>
                                    
                                    </tbody>
                                </table>
                            </div>
                                <?php else: ?>
                                <div class="row text-center">
                                    <h2>No details</h2>
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

   

    <!-- Modal -->
   


    <!-- /Notification Modal -->
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('hrms.layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>