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
                    <a href="/employee-manager"> Employee listing </a>
                </li>
                <li class="breadcrumb-current-item"> Documents </li>
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
                            <span class="panel-title hidden-xs"> Document Lists </span><br />
                        </div><br />
             
                        <div class="panel-body pn">
                            <?php if(Session::has('flash_message')): ?>
                                <div class="alert alert-success">
                                    <?php echo e(Session::get('flash_message')); ?>

                                </div>
                            <?php endif; ?>

                            <?php if(count($details)): ?>
                            <div class="table-responsive">
                                <table class="table allcp-form theme-warning tc-checkbox-1 fs13">
                                    <thead>
                                    <tr class="bg-light">
                                        <th class="text-center">Id</th>
                                        <th class="text-center">File name</th> 
                                        <th class="text-center">Comments</th>
                                        <th class="text-center">Uploaded Date</th>
                                         <th class="text-center">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i =0;?>
                                    <?php foreach($details as $detail): ?>
                                        <tr>
                                            <td class="text-center"><?php echo e($i+=1); ?></td>
                                            
                                             <td class="text-center"><a href="/downloademployeedocs/<?php echo e($detail->id); ?>"><?php echo e($detail->filename); ?> </a></td>
                                            <td class="text-center"><?php echo e($detail->comment); ?></td>
                                           
                                            <td class="text-center"><?php echo e(getFormattedDate($detail->upload_at)); ?></td>
                                                  <td class="text-center">
                                            <div class="btn-group text-right">
                                                <button type="button"
                                                        class="btn btn-info br2 btn-xs fs12 dropdown-toggle"
                                                        data-toggle="dropdown" aria-expanded="false"> Action
                                                    <span class="caret ml5"></span>
                                                </button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li>
                                                        <a href="/delete-emp-document/<?php echo e($detail->id); ?>">Delete</a>
                                                    </li>
                                                    
                                                </ul>
                                            </div>
                                        </td>
                                             
                                        </tr>
                                    <?php endforeach; ?>
                                    <tr><td colspan="5">
                                            <?php echo $details->render(); ?>

                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                                <?php else: ?>
                                <div class="row text-center">
                                    <h2>No documents to show</h2>
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



    <!-- /Notification Modal -->
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('hrms.layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>