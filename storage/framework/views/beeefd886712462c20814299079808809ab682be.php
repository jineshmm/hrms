<?php $__env->startSection('content'); ?>

    <section id="content" class="animated fadeIn">

        <div class="row">

            <div class="col-md-4">
                <div class="box box-success">
                    <div class="panel">
                        <div class="panel-heading text-center">
                            <span class="panel-title"><?php echo e($details->name); ?></span>
                        </div>
                        <div class="panel-body pn pb5 text-center">
                            <hr class="short br-lighter">
                            <img src="<?php echo e(($details->photo) ? "/photos/".$details->photo : '/assets/img/avatars/profile_pic.png'); ?>" width="80px" height="80px" class="img-circle img-thumbnail" alt="User Image">

                        </div>
                        <p class="text-center no-margin"><?php echo e($details->userrole->role->name); ?></p>
                        <p class="small text-center no-margin"><span class="text-muted">Department:</span> <?php echo e($details->department->title); ?></p>
                        <p class="small text-center no-margin"><span class="text-muted">Employee ID:</span> <?php echo e($details->code); ?></p>


                    </div>
                </div>

                <div class="box box-success">
                    <div class="panel">
                        <div class="panel-heading">
                            <span class="panel-title">Bank Details</span>
                        </div>
                        <div class="panel-body pn pb5">
                            <hr class="short br-lighter">

                            <div class="box-body no-padding">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td style="width: 10px" class="text-center"><i class="fa fa-credit-card"></i></td>
                                        <td><strong>Account Number</strong></td>
                                        <td><?php echo e($details->account_number); ?></td>

                                    </tr>
<!--                                    <tr>
                                        <td style="width: 10px" class="text-center"><i class="fa fa-tags"></i></td>
                                        <td><strong>Pf Account Number</strong></td>
                                        <td><?php echo e($details->pf_account_number); ?></td>
                                    </tr>-->
                                    <tr>
                                        <td style="width: 10px" class="text-center"><i class="fa fa-bank"></i></td>
                                        <td><strong>Bank Name</strong></td>
                                        <td><?php echo e($details->bank_name); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 10px" class="text-center"><i class="fa fa-code"></i></td>
                                        <td><strong>IBAN</strong></td>
                                        <td><?php echo e($details->ifsc_code); ?></td>
                                    </tr>
<!--                                    <tr>
                                        <td style="width: 10px" class="text-center"><i class="fa fa-tags"></i></td>
                                        <td><strong>Un Number</strong></td>
                                        <td><?php echo e($details->un_number); ?></td>
                                    </tr>-->
                                    </tbody>
                                </table>
                            </div>


                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="box box-success">
                    <div class="panel">

                        <div class="panel-heading">
                            <span class="panel-title">Personal Details</span>
                        </div>
                        <div class="panel-body pn pb5">
                            <hr class="short br-lighter">


                            <div class="box-body no-padding">

                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td style="width: 10px" class="text-center"><i class="fa fa-birthday-cake"></i>
                                        </td>
                                        <td><strong>Birthday</strong></td>
                                        <td><?php echo e($details->date_of_birth); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 10px" class="text-center"><i class="fa fa-genderless"></i>
                                        </td>
                                        <td><strong>Gender</strong></td>
                                        <td><?php echo e(getGender($details->gender)); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 10px" class="text-center"><i class="fa fa-envelope-o"></i>
                                        </td>
                                        <td><strong>Father's Name</strong></td>
                                        <td><?php echo e($details->father_name); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 10px" class="text-center"><i class="fa fa-mobile-phone"></i>
                                        </td>
                                        <td><strong>Cellphone</strong></td>
                                        <td><?php echo e($details->number); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 10px" class="text-center"><i class="fa fa-map-marker"></i>
                                        </td>
                                        <td><strong>Qualification</strong></td>
                                        <td><?php echo e($details->qualification); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 10px" class="text-center"><i class="fa fa-map-marker"></i>
                                        </td>
                                        <td><strong>Current Address</strong></td>
                                        <td><?php echo e($details->current_address); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 10px" class="text-center"><i class="fa fa-map-marker"></i>
                                        </td>
                                        <td><strong>Permanent Address</strong></td>
                                        <td><?php echo e($details->permanent_address); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 10px" class="text-center"><i class="fa fa-map-marker"></i>
                                        </td>
                                        <td><strong>Remaining leaves</strong></td>
                                        <td><b style="color:orangered"><?php echo e($remainingLeaves); ?></b></td>
                                    </tr>
                                    
                                    </tbody>
                                </table>


                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <div class="col-md-3 pull-right">
                <div class="small-box bg-black">
                    <div class="inner datebar" align="center">
                        <p style="color:ghostwhite"><?php echo e(\Carbon\Carbon::now()->format('l, jS \\of F, Y')); ?></p>
                        <h3 style="color: ghostwhite" id="clock"></h3>
                        <br/>
                    </div>
                </div>
            </div>

            <?php if($events): ?>
            <div class="col-md-3 pull-right">
                <div class="box box-success">
                    <div class="panel">
                        <div class="panel-heading">
                            <span class="panel-title"> Events </span>
                        </div>
                        <div class="panel-body pn pb5">
                            <hr class="short br-lighter">
                                <?php foreach(array_chunk($events, 3, true) as $results): ?>
                                    <table class="table">
                                        <?php foreach($results as $event): ?>
                                             <tr>
                                                <td>
                                                    <div class='fc-event' data-event="primary">
                                                        <div class="fc-event-desc blink" id="blink">
                                                            <span class="label label-info pull-right">  <?php echo e($event->name); ?> </span></a>
                                                        </div>
                                                    </div>
                                                    <a href="<?php echo e(route('create-event')); ?>" > <span class="label label-success pull-right"><?php echo e(\Carbon\Carbon::createFromTimestamp(strtotime($event->date))); ?></span></a>
                                                </td>
                                             </tr>
                                        <?php endforeach; ?>
                                    </table>
                                <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <div class="col-md-5">
                <div class="box box-success">
                    <div class="panel">
                        <div class="panel-heading">
                            <span class="panel-title">Employment Details</span>
                        </div>
                        <div class="panel-body pn pb5">
                            <hr class="short br-lighter">

                            <div class="box-body no-padding">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td style="width: 10px" class="text-center"><i class="fa fa-key"></i></td>
                                        <td><strong>Employee ID</strong></td>
                                        <td><?php echo e($details->code); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center"><i class="fa fa-briefcase"></i></td>
                                        <td><strong>Department</strong></td>
                                        <td><?php echo e($details->department->title); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center"><i class="fa fa-cubes"></i></td>
                                        <td><strong>Designation</strong></td>
                                        <td><?php echo e($details->userrole->role->name); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center"><i class="fa fa-calendar"></i></td>
                                        <td><strong>Date Joined</strong></td>
                                        <td><?php echo e($details->date_of_joining); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center"><i class="fa fa-calendar"></i></td>
                                        <td><strong>Date Confirmed</strong></td>
                                        <td><?php echo e($details->date_of_confirmation); ?></td>
                                    </tr>
                             
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
                    </div>
            </div>

        </div>

    </section>

<?php $__env->stopSection(); ?>
<script type="text/javascript">
    function startTime() {
        var today = new Date(),
                curr_hour = today.getHours(),
                curr_min = today.getMinutes(),
                curr_sec = today.getSeconds();
        curr_hour = checkTime(curr_hour);
        curr_min = checkTime(curr_min);
        curr_sec = checkTime(curr_sec);
        document.getElementById('clock').innerHTML = curr_hour + ":" + curr_min + ":" + curr_sec;
    }
    function checkTime(i) {
        if (i < 10) {
            i = "0" + i;
        }
        return i;
    }
    setInterval(startTime, 500);
</script>

<?php echo $__env->make('hrms.layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>