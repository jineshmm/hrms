Dear <?php echo e($user->name); ?>,

<br/><br/>
<?php if($status == 'approved'): ?>
    Congratulations ! Your leave request for <?php echo e(getLeaveType($leave->leave_type_id)); ?> for <?php echo e($leave->days); ?> day(s)
    has been approved with the following remark <i>"<?php echo e($remarks); ?>"</i>.
<?php else: ?>
    Unfortunately your leave request for <?php echo e(getLeaveType($leave->leave_type_id)); ?> for <?php echo e($leave->days); ?> day(s) cannot be approved
    with the following remark <i>"<?php echo e($remarks); ?>"</i>.
<?php endif; ?>
<br />
<br />

Thanks & Regards
<br />
Human Resource Department
<br />
Digital IP Insights
