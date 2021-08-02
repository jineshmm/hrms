<?php

function totalLeaves($leaveType) {
    $result = [
        '1' => '30', //Annual leaves
        '2' => '0', //sick leave
        '3' => '0', //marriage leave
        '4' => '10', //bereavement leave
        '6' => '15', //paternity leave
        '12' => '90', //maternity leave
        '7' => '0',
        '8' => '0',
        '9' => '0',
        '10' => '0',
        '11' => '0',
    ];

    return $result[$leaveType];
}

function convertRole($role) {
    $data = [
        'Admin' => '1',
        'Director' => '2',
        'Research Analyst' => '3',
        'Senior Research Analyst' => '4',
        'Team Lead' => '5',
        'IT Executive' => '6',
        'HR Manager' => '7',
        'Associate-Enforcement' => '8',
        'Enforcement Head' => '9',
        'Finance Controller' => '10',
        'Consultant' => '11',
        'Front desk Executive' => '12',
        'Software Developer' => '13',
        'Senior Software Developer' => '14',
        'Accounts Executive' => '15',
        'Manager' => '16'
            //bharo baki
    ];
    if ($role) {
        return $data[$role];
    }

    return $data;
}

function convertStatus($emp_status) {

    $data = [
        'Present' => 1,
        'Ex' => 0,
    ];

    return $data[$emp_status];
}

function convertStatusBack($emp_status) {

    $data = [
        1 => 'Present',
        0 => 'Ex',
    ];
    if (is_null($emp_status)) {
        
        return $data[1];
    }

    return $data[$emp_status];
}

function getLeaveType($leave_id) {
    $result = \App\Models\LeaveType::where('id', $leave_id)->first();

    return $result->leave_type;
}

function covertDateToDay($date) {
    $day = strtotime($date);
    $day = date("l", $day);

    return strtoupper($day);
}

/*
  function getFormattedDate($date)
  {
  $date = new DateTime($date);
  return date_format($date, 'l jS \\of F Y');
  } */

function getFormattedDate($date) {
    $date = strtotime($date);

    return date('Y-m-d', $date);
}

function getEmployeeDropDown() {
    $data = [
        "" => "Select",
        'name' => 'Name',
        'code' => 'Code',
        'department' => 'Department',
        'email' => 'Email',
        'number' => 'Number',
    ];

    return $data;
}

function getLeaveColumns() {
    $data = [
        "" => "Select",
        'name' => 'Name',
        'code' => 'Code',
        'days' => 'Days',
        'leave_type' => 'Leave type',
        'status' => 'Status',
    ];

    return $data;
}

function getLoanColumns() {
    $data = [
        "" => "Select",
        'name' => 'Name'
    ];

    return $data;
}

function getAttendanceDropDown() {
    $data = [
        "" => "Select",
        'name' => 'Name',
        'code' => 'Code',
        'date' => 'Date',
        'day' => 'Day',
        'hours_worked' => 'Hours Worked',
        'status' => 'Status',
    ];

    return $data;
}

function getHoursWorked($inTime, $outTime) {

    $result = strtotime($outTime) - strtotime($inTime);
    $totalMinutes = abs($result) / 60;

    $minutes = $totalMinutes % '60';
    $hours = $totalMinutes - $minutes;
    $hours = $hours / 60;

    return $hours . ':00' . $minutes . ':00';
}

function convertAttendanceTo($status) {
    $data = [
        'A' => '0',
        'P' => '1',
        'MIS' => '2',
        'WO' => '3',
        'HLF' => '4',
    ];

    return $data[$status];
}

function convertAttendanceFrom($status) {
    $data = [
        '0' => 'A',
        '1' => 'P',
        '2' => 'MIS',
        '3' => 'WO',
        '4' => 'HLF',
    ];

    return $data[$status];
}

function qualification() {
    $data = [
        '' => 'Select one',
        'B.Com' => 'B.Com',
        'B.Sc' => 'B.Sc',
        'BCA' => 'BCA',
        'MCA' => 'MCA',
        'BCA+MCA' => 'BCA+MCA',
        'BBA' => 'BBA',
        'MBA' => 'MBA',
        'BBA+MBA' => 'BBA+MBA',
        'Engineering(B.Tech)' => 'Engineering(B.Tech)',
        'Engineering(B.Tech+M.Tech)' => 'Engineering(B.Tech+M.Tech)',
        'Other' => 'Other',
    ];

    return $data;
}

function getGender($gender) {
    $data = [
        '0' => 'Male',
        '1' => 'Female',
    ];

    return $data[$gender];
}

function formatDate($date) {
    $created_at = $date;
    $today = \Carbon\Carbon::now();
    $difference = date_diff($created_at, $today);

    if ($difference->days > 1) {
        //{{$job->created_at ? $job->created_at->format('l jS \\of F Y') : ''}}
        return $date->format('l jS \\of F Y H:m:s');
    }

    return $date->diffForHumans();
}

function getUserData($userId) {
    $user = \App\User::where('id', $userId)->with('employee')->first();

    return $user;
}

function getLoanType($typeId) {

    $loanType = array(1 => "Car Loan", 2 => "Housing Loan", 3 => "Air Tickets Loan", 4 => "Personal Loan", 5 => "Salary Loan", 6 => "Study Loan");
    if ($typeId != '') {
        $type = $loanType[$typeId];
    } else {
        $type = '';
    }
    return $type;
}

function getTotalLeaveColumns() {
    $data = [
        "" => "Select",
        'name' => 'Name',
        'code' => 'Code',
        'leave_type' => 'Leave type',
    ];

    return $data;
}

function getTerminationColumns() {
    $data = [
        "" => "Select",
        'name' => 'Name',
        'code' => 'Code',
    ];

    return $data;
}

function getLoanreportColumns() {
    $data = [
        "" => "Select",
        'name' => 'Name',
        'code' => 'Code',
        'loantype' => 'Loan type'
    ];

    return $data;
}

function getMonthString($month) {
    $data = [
        '1' => 'January',
        '2' => 'February',
        '3' => 'March',
        '4' => 'April',
        '5' => 'May',
        '6' => 'June',
        '7' => 'July',
        '8' => 'August',
        '9' => 'September',
        '10' => 'October',
        '11' => 'November',
        '12' => 'December',
    ];

    return $data[$month];
}

function getMonthlist() {
  $data = [
        '1' => 'January',
        '2' => 'February',
        '3' => 'March',
        '4' => 'April',
        '5' => 'May',
        '6' => 'June',
        '7' => 'July',
        '8' => 'August',
        '9' => 'September',
        '10' => 'October',
        '11' => 'November',
        '12' => 'December',
    ];

    return $data;  
}

function getGosireportColumns() {
  $data = [
        "" => "Select",
        'name' => 'Name',
        'code' => 'Code',
        'year' => 'Year'
    ];

    return $data;  
}