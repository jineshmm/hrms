/**
 * Created by kanak on 1/6/16.
 */
var datepicker1 = $('#datepicker1');
var datepicker4 = $('#datepicker4');
var datepicker2 = $('#datepicker2');

datepicker4.on('change', function () {
    var date_from = datepicker1.val();
    var new_date_from = new Date(date_from);
    var date_to = datepicker4.val();
    var new_date_to = new Date(date_to);
    if (date_from > date_to) {
        alert('To Date cannot be smaller than From Date');
        datepicker4.val('');
    } else {
        var timeDiff = Math.abs(new_date_to.getTime() - new_date_from.getTime());
        var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));

        if (diffDays == 1) {
            diffDays = 2;
        }

        if (diffDays == 0) {
            var time_from = date_from + ' ' + $('#timepicker1').val() + ':00';
            var time_to = date_to + ' ' + $('#timepicker4').val() + ':00';

            var diff = moment.duration(moment(time_to).diff(moment(time_from)));
            diff = diff / 3600 / 1000;
            if (diff <= 4) {
                $('#total_days').val('Half day leave');
            } else if (diff > 4) {
                $('#total_days').val('Full day leave');
            }
        } else {
            if (diffDays > 1) {
                $('#total_days').val(toWords(diffDays) + 'days leave');
            } else {
                $('#total_days').val(toWords(diffDays) + 'day leave');
            }
        }
    }
});

datepicker1.on('change', function () {
    var date_from = datepicker1.val();
    var new_date_from = new Date(date_from);
    var date_to = datepicker4.val();
    var new_date_to = new Date(date_to);
    var timeDiff = Math.abs(new_date_to.getTime() - new_date_from.getTime());
    var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));

    if (diffDays == 1) {
        diffDays = 2;
    }

    if (diffDays == 0) {
        var time_from = date_from + ' ' + $('#timepicker1').val() + ':00';
        var time_to = date_to + ' ' + $('#timepicker4').val() + ':00';

        var diff = moment.duration(moment(time_to).diff(moment(time_from)));
        diff = diff / 3600 / 1000;
        if (diff <= 5) {
            $('#total_days').val('Half day leave');
        } else if (diff > 5) {
            $('#total_days').val('Full day leave');
        }
    } else {
        if (diffDays > 1) {
            $('#total_days').val(toWords(diffDays) + 'days leave');
        } else {
            $('#total_days').val(toWords(diffDays) + 'day leave');
        }
    }
    //}
});

$('#timepicker4').on('change', function () {
    var date_from = datepicker1.val();
    var new_date_from = new Date(date_from);
    var date_to = datepicker4.val();
    var new_date_to = new Date(date_to);
    var timeDiff = Math.abs(new_date_to.getTime() - new_date_from.getTime());
    var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));

    if (diffDays == 1) {
        diffDays = 2;
    }
    if (diffDays == 0) {
        var time_from = date_from + ' ' + $('#timepicker1').val() + ':00';
        var time_to = date_to + ' ' + $('#timepicker4').val() + ':00';

        var diff = moment.duration(moment(time_to).diff(moment(time_from)));
        diff = diff / 3600 / 1000;
        if (diff <= 3.5) {
            $('#total_days').val('First half leave');
        } else if (diff > 3.5 && diff < 5) {
            $('#total_days').val('Second half leave');
        } else if (diff > 5) {
            $('#total_days').val('Full day leave');
        }
    } else {
        if (diffDays > 1) {
            $('#total_days').val(toWords(diffDays) + 'days leave');
        } else {
            $('#total_days').val(toWords(diffDays) + 'day leave');
        }
    }
});


// Convert numbers to words
// copyright 25th July 2006, by Stephen Chapman http://javascript.about.com
// permission to use this Javascript on your web page is granted
// provided that all of the code (including this copyright notice) is
// used exactly as shown (you can change the numbering system if you wish)

// American Numbering System
var th = ['', 'thousand', 'million', 'billion', 'trillion'];
// uncomment this line for English Number System
// var th = ['','thousand','million', 'milliard','billion'];

var dg = ['zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];
var tn = ['ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'];
var tw = ['twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];
function toWords(s) {
    s = s.toString();
    s = s.replace(/[\, ]/g, '');
    if (s != parseFloat(s))
        return 'Please select both days ';
    var x = s.indexOf('.');
    if (x == -1)
        x = s.length;
    if (x > 15)
        return 'too big';
    var n = s.split('');
    var str = '';
    var sk = 0;
    for (var i = 0; i < x; i++) {
        if ((x - i) % 3 == 2) {
            if (n[i] == '1') {
                str += tn[Number(n[i + 1])] + ' ';
                i++;
                sk = 1;
            } else if (n[i] != 0) {
                str += tw[n[i] - 2] + ' ';
                sk = 1;
            }
        } else if (n[i] != 0) {
            str += dg[n[i]] + ' ';
            if ((x - i) % 3 == 0)
                str += 'hundred ';
            sk = 1;
        }
        if ((x - i) % 3 == 1) {
            if (sk)
                str += th[(x - i - 1) / 3] + ' ';
            sk = 0;
        }
    }
    if (x != s.length) {
        var y = s.length;
        str += 'point ';
        for (var i = x + 1; i < y; i++)
            str += dg[n[i]] + ' ';
    }
    return str.replace(/\s+/g, ' ');
}

$(document).off('change', '.leave_type');
$(document).on('change', '.leave_type', function () {
    var showLeaveCount = $('#show-leave-count');
    var leaveTypeId = $('.leave_type').val();
    var token = $('#token').val();
    var userId = $('#user_id').val();
    var leaveEndDate = $('#datepicker4').val();

    $.post('/get-leave-count', {'leaveTypeId': leaveTypeId, '_token': token, 'userId': userId,'leaveEnd':leaveEndDate}, function (data) {
        parsed = JSON.parse(data);
        showLeaveCount.empty();
        var html = "<div class=' col-md-5 alert alert-dark center-block '>Leaves &nbsp Remaining : " + parsed + "</div>";
        showLeaveCount.append(html);

    });

});

$('.approveClick').click(function () {
    var leaveId = $(this).data('id');
    var type = $(this).data('name');
    var approvedby = $(this).data('approved-by');
    var token = $('#token').val();
    $('#leave_id').val(leaveId);
    $('#type').val(type);
    $('#approved_by').val(approvedby);

    if (approvedby === 2) {
        $('.finance_approve').show();
    } else {
        $('.finance_approve').hide();
        $('.finance_approve option[value="0"]').prop('selected', true);
    }

    $('#remarkModal').modal('show');

});

$('#proceed-button').click(function () {
    $('#loader').removeClass('hidden');

    var remarks = $('#remark-text').val();
    var type = $('#type').val();

    var leave_id = $('#leave_id').val();
    var approvedBy = $('#approved_by').val();
    var token = $('#token').val();
    var message = '';
    var divClass = 'alert-success';
    var url = '/approve-leave';
    var buttonText = 'Approved';
    var buttonClass = 'btn-success';
    var buttonIcon = 'fa-check';
    var ticket_flag = 0;
    var exit_flag = 0;
    var exit_period = 0;
    //ticket count details
    var spouse_ticket = $('#ticket_spouse').val();
    var children_ticket = $('#ticket_children').val();
    
    
    if (type == 'approve') {
        message = 'Successfully Approved';
        ticket_flag = $('#ticket_flag').val();
        exit_flag = $('#exit_flag').val();
        exit_period = $('#exit_period').val();
    } else {
        message = 'Leave Rejected';
        divClass = 'alert-danger';
        url = '/disapprove-leave';
        buttonText = 'Disapproved';
        buttonClass = 'btn-danger';
        buttonIcon = 'fa-times';

    }

    $.post(url, {'leaveId': leave_id, 'remarks': remarks, '_token': token, 'approvedBy': approvedBy, 'ticket_approve': ticket_flag, 'exitFlag': exit_flag, 'exitPeriod': exit_period,'ticket_spouse':spouse_ticket,'ticket_children':children_ticket}, function (data) {
        var parsed = JSON.parse(data);
        if (parsed === 'success') {
            $('#loader').addClass('hidden');
            var statusmessage = $('#status-message');
            statusmessage.append("<div class='alert " + divClass + "'>" + message + "</div>");
            statusmessage.removeClass('hidden');
            var remarks_div = $('#remark-' + leave_id);
            remarks_div.append(remarks);
            var leavebutton = $('#button-' + leave_id);
            if (approvedBy === 2) {
                leavebutton = $('#button-hr-' + leave_id);
            }

            leavebutton.empty();
            leavebutton.append("<button type='button' class='btn " + buttonClass + " br2 btn-xs fs12' aria-expanded='false'><i class='fa " + buttonIcon + "'>" + buttonText + "</i> </button>");

            setTimeout(function () {
                $('#remarkModal').modal('hide');
                $('#disapproveModal').modal('hide');
            }, 4000);


        }
    });
});

$('.disapproveClick').click(function () {
    var leaveId = $(this).data('id');
    var token = $('#token').val();
    var approvedby = $(this).data('approved-by');
    $('#leave_id').val(leaveId);
    $('#approved_by').val(approvedby);
    $('#disapproveModal').modal('show');

});


$('.loanapproveClick').click(function () {
    var loanId = $(this).data('id');
    var type = $(this).data('name');
    var approvedby = $(this).data('approved-by');
    var token = $('#token').val();
    $('#loan_id').val(loanId);
    $('#type').val(type);
    $('#approved_by').val(approvedby);


    $('#approveModal').modal('show');

});

$('.loandisapproveClick').click(function () {
    var leaveId = $(this).data('id');
    var token = $('#token').val();
    var approvedby = $(this).data('approved-by');
    $('#loan_id').val(leaveId);
    $('#approved_by').val(approvedby);
    $('#approveModal').modal('show');

});

$('#loan_proceed-button').click(function () {
    $('#loader').removeClass('hidden');

    var remarks = $('#remark-text').val();
    var type = $('#type').val();

    var loan_id = $('#loan_id').val();
    var approvedBy = $('#approved_by').val();
    var token = $('#token').val();
    var message = '';
    var divClass = 'alert-success';
    var url = '/approve-loan';
    var buttonText = 'Approved';
    var buttonClass = 'btn-success';
    var buttonIcon = 'fa-check';

    if (type == 'approve') {
        message = 'Successfully Approved';
    } else {
        message = 'Loan request rejected';
        divClass = 'alert-danger';
        url = '/disapprove-loan';
        buttonText = 'Disapproved';
        buttonClass = 'btn-danger';
        buttonIcon = 'fa-times';
    }

    $.post(url, {'loanId': loan_id, 'remarks': remarks, '_token': token, 'approvedBy': approvedBy}, function (data) {
        var parsed = JSON.parse(data);
        if (parsed === 'success') {
            $('#loader').addClass('hidden');
            var statusmessage = $('#status-message');
            statusmessage.append("<div class='alert " + divClass + "'>" + message + "</div>");
            statusmessage.removeClass('hidden');
            var remarks_div = $('#remark-' + loan_id);
            remarks_div.append(remarks);
            var leavebutton = $('#button-' + loan_id);
            if (approvedBy === 2) {
                leavebutton = $('#button-hr-' + loan_id);
            }

            leavebutton.empty();
            leavebutton.append("<button type='button' class='btn " + buttonClass + " br2 btn-xs fs12' aria-expanded='false'><i class='fa " + buttonIcon + "'>" + buttonText + "</i> </button>");
            setTimeout(function () {
                $('#approveModal').modal('hide');
            }, 4000);


        }
    });
});


$('#passwordForm').submit(function (event) {
    event.preventDefault();
    var old_password = $('#old_password').val();
    var new_password = $('#new_password').val();
    var confirm_password = $('#confirm_password').val();

    if (new_password != confirm_password) {
        alert('New password and confirm password does not match');
        return false;
    }
    document.getElementById("passwordForm").submit();

});

$('#create-event').click(function () {
    $('#status-section').removeClass('hidden');
    var name = $('#event_name').val();
    var coordinator = $('#event_cordinater').val();
    var attendees = $('#event_attendees').val();
    var date = $('#date_time').val();
    var message = $('#event_description').val();
    var token = $('#token').val();

    $.post('create-event', {
        'name': name,
        'coordinator': coordinator,
        'attendees': attendees,
        'date': date,
        'message': message,
        '_token': token
    }, function (data) {
        $('#status-section').addClass('hidden');
        $('#message-section').removeClass('hidden');
        var parsed = JSON.parse(data);

        if (parsed === 'success') {
            alert(parsed);
        }
    });

});

$('#create-meeting').click(function () {
    $('#status-section').removeClass('hidden');
    var name = $('#meeting_name').val();
    var coordinator = $('#meeting_cordinater').val();
    var attendees = $('#meeting_attendees').val();
    var date = $('#date_time').val();
    var message = $('#meeting_description').val();
    var token = $('#token').val();

    $.post('create-meeting', {
        'name': name,
        'coordinator': coordinator,
        'attendees': attendees,
        'date': date,
        'message': message,
        '_token': token
    }, function (data) {
        $('#status-section').addClass('hidden');
        $('#message-section').removeClass('hidden');
        var parsed = JSON.parse(data);
        if (parsed === 'success') {
            alert(parsed);
        }
    });

});

$(document).on('change', '#qualification', function () {
    var value = $('.qualification_select').val();
    if (value == 'Other') {
        $('.qualification_text').removeClass('hidden');
    } else if (value != 'Other') {
        $('.qualification_text').addClass('hidden');
    }
});

$(document).on('change', '#probation_period', function () {
    var value = $('.probation_select').val();
    if (value == 'Other') {
        $('.probation_text').removeClass('hidden');
    } else if (value != 'Other') {
        $('.probation_text').addClass('hidden');
    }
});


function DropDownChanged(oDDL) {
    var oTextbox = oDDL.form.elements["qualification_text"];
    if (oTextbox) {
        oTextbox.style.display = (oDDL.value == "") ? "" : "none";
        if (oDDL.value == "")
            oTextbox.focus();
    }
}

function FormSubmit(oForm) {
    var oHidden = oForm.elements["qualification"];
    var oDDL = oForm.elements["qualification_list"];
    var oTextbox = oForm.elements["qualification_text"];
    if (oHidden && oDDL && oTextbox)
        oHidden.value = (oDDL.value == "") ? oTextbox.value : oDDL.value;
}


/*
 var number = 10;
 
 function doStuff() {
 number = number +10;
 $('.progress-bar').attr('aria-valuenow', number).css('width',number);
 }*/


$('.showModal').click(function () {
    var info = $(this).data('info');
    var employee_id = info['employee']['id'];
    var employee_name = info['name'];
    var bank_name = info['employee']['bank_name'];
    var account_number = info['employee']['account_number'];
    var ifsc_code = info['employee']['ifsc_code'];
    var iqama_number = info['employee']['iqama_number'];

    $('#employee_name').val(employee_name);
    $('#bank_name').val(bank_name);
    $('#account_number').val(account_number);
    $('#ifsc_code').val(ifsc_code);
    $('#iqama_number').val(iqama_number);
    $('#emp_id').val(employee_id);
    $('#bankModal').modal('show');
});

$('#update-bank-account-details').click(function () {
    swal(
            "Please wait while we process your request"
            );

    var employee_id = $('#emp_id').val();
    var employee_name = $('#employee_name').val();
    var bank_name = $('#bank_name').val();
    var account_number = $('#account_number').val();
    var ifsc_code = $('#ifsc_code').val();
    var iqama_number = $('#iqama_number').val();
    var token = $('#token').val();

    $.post('/update-account-details', {
        'employee_id': employee_id,
        'employee_name': employee_name,
        'bank_name': bank_name,
        'account_number': account_number,
        'ifsc_code': ifsc_code,
        'iqama_number': iqama_number,
        '_token': token
    }, function (data) {
        var parsed = JSON.parse(data);

        if (parsed == 'success') {
            swal({
                title: "Success!",
                text: "Bank Details Successfully updated!",
                type: "success",
                confirmButtonText: "OK",
                allowEscapeKey: true,
                allowOutsideClick: true
            },
                    function () {
                        location.reload(true);
                    });
        } else {
            swal({
                title: "Error!",
                text: "Sorry, details not update!",
                type: "error",
                confirmButtonText: "OK",
                allowEscapeKey: true,
                allowOutsideClick: true
            },
                    function () {
                        location.reload(true);
                    });
        }
    });
});

$(document).on('change', '#promotion_emp_id', function () {

    var oldDesignation = $('#old_designation');
    var oldSalary = $('#old_salary');
    var emp_id = $('#promotion_emp_id').val();
    
    var token = $('#token').val();

    $.post('/get-promotion-data', {'employee_id': emp_id, '_token': token}, function (data) {
        var parsed = JSON.parse(data);
        if (parsed.status == 'success') {
            oldDesignation.val('');
            oldDesignation.val(parsed.data.designation);
            oldSalary.val('');
            oldSalary.val(parsed.data.salary);
            $('#employee_type').val(parsed.data.emptype);
            
        } else {

        }
    });
});

$('#post-update').click(function ()
{
    var postUpdate = $('#post-update');
    $('#post-button').css('padding-left', '80%');
    postUpdate.val('Posting...');
    var status = $('#status').val();
    var token = $('meta[name=csrf_token]').attr("content");
    $.post('/status-update', {'status': status, '_token': token}, function (data)
    {
        var parsed = JSON.parse(data);
        if (parsed.status)
        {
            $('.append-post').prepend(parsed.html);
        }
        $('#post-button').css('padding-left', '90%');
        postUpdate.val('Post');
    });
});

$('.post-reply').click(function ()
{
    var postId = $(this).data('post_id');
    var postUpdate = $('.post-reply');
    $('.reply-button').css('padding-left', '75%');
    postUpdate.val('Replying...');
    var reply = $('.reply');
    var token = $('meta[name=csrf_token]').attr("content");
    $.post('/post-reply', {'reply': reply.val(), 'post_id': postId, '_token': token}, function (data)
    {
        var parsed = JSON.parse(data);
        if (parsed.status)
        {
            $('.container-for-reply-' + postId).append(parsed.html);
        }
        reply.val('');
        $('.reply-button').css('padding-left', '80%');
        postUpdate.val('Reply');
    });
});


$('#code').blur(function () {
    var code = $(this).val();
    var codeGroup = $('.code-group');

    $.get('/validate-code/' + code, function (data)
    {
        var parsed = JSON.parse(data);
        if (parsed.status)
        {
            $('.btn-info').removeAttr('disabled');
            codeGroup.removeClass('has-error');
            codeGroup.addClass('has-success');
        } else
        {
            codeGroup.removeClass('has-success');
            codeGroup.addClass('has-error');
        }
    });
});

$('.approverequestClick').click(function () {
    var expenseId = $(this).data('id');
    var type = $(this).data('name');

    var token = $('#token').val();
    $('#expense_id').val(expenseId);
    $('#type').val(type);


    $('#remarkModal').modal('show');

});



$('.disapproverequestClick').click(function () {
    var leaveId = $(this).data('id');
    var token = $('#token').val();

    $('#expense_id').val(leaveId);

    $('#remarkModal').modal('show');

});
//#######################################################

$('.approveexpenseClick').click(function () {
    var expId = $(this).data('id');
    var type = $(this).data('name');
    var leaveId = $(this).data('leaveid');
    var empId = $(this).data('empid');


    ($(this).data('self') > 0) ? $("#ticket_self").attr('value',$(this).data('self')):$("#ticket_self").attr('value',0);
    ($(this).data('spouse') > 0) ? $("#ticket_spouse").attr('value',$(this).data('spouse')):$("#ticket_spouse").attr('value',0);
    ($(this).data('child') > 0) ? $("#ticket_children").attr('value',$(this).data('child')):$("#ticket_children").attr('value',0);
    
    
    $('#request_id').val(expId);
    $('#leavereq_id').val(leaveId);

    $('#status-message').hide();
  
         $.ajax({
                  url: '/checkticketavailability',
                  type: "post",
                  data: { "empId": empId, "leaveId": leaveId },
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                  }
                }).done(function(data) {
                  if (data.status) {
                   (data.selfticketCount > 0) ? $("#available_ticket_self").val(data.selfticketCount):$("#available_ticket_self").val(0);
                    (data.spouceticketCount > 0) ? $("#available_ticket_spouse").val(data.spouceticketCount):$("#available_ticket_spouse").val(0);
                    (data.childticketCount > 0) ? $("#available_ticket_children").val(data.childticketCount):$("#available_ticket_children").val(0);
                    
                    
                    (data.selfticketCount > 0) ? $("#ticket_self").attr('max',data.selfticketCount):$("#ticket_self").attr('max',1);
                    (data.spouceticketCount > 0) ? $("#ticket_spouse").attr('max',data.spouceticketCount):attr('max',0);
                    (data.childticketCount > 0) ? $("#ticket_children").attr('max',data.childticketCount):$("#ticket_children").attr('max',0);
                    
                    $('#closeModal').modal('show');
                  }


                });
    
    
    
//    $.ajax( {
//				"url": '/checkticketavailability',
//				"data": [
//					{ "empId": empId, "leaveId": leaveId }
//				],
//				"success": function (data) {
//					$('#closeModal').modal('show');
//				}
//				"dataType": "json",
//				"type": "get",
//                                 "headers": {
//                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//                                },
//				"cache": false,
//				"error": function () {
//					alert( "Error detected when sending table data to server" );
//				}
//			} );
    

});







$('body').off('click', '.disapproveexpenseClick');
$('.disapproveexpenseClick').click(function () {
    var expId = $(this).data('id');
    var token = $('#token').val();

    $('#exp_id').val(expId);
    $('#status-message').hide();
    $('#remarkModal').modal('show');

});

$('#proceed-button-expense').click(function () {
    $('#loader').removeClass('hidden');

    var remarks = $('#remark-text').val();
    var type = $('#type').val();

    var expense_id = $('#exp_id').val();

    var token = $('#token').val();
    var message = '';
    var divClass = 'alert-success';
    var url = '/approve-expense';
    var buttonText = 'Approved';
    var buttonClass = 'btn-success';
    var buttonIcon = 'fa-check';

    if (type == 'approve') {
        message = 'Successfully Approved';
    } else {
        message = 'Ticket request rejected';
        divClass = 'alert-danger';
        url = '/disapprove-expense';
        buttonText = 'Disapproved';
        buttonClass = 'btn-danger';
        buttonIcon = 'fa-times';
    }

    $.post(url, {'expId': expense_id, 'remarks': remarks, '_token': token}, function (data) {
        var parsed = JSON.parse(data);
        if (parsed === 'success') {
            $('#loader').addClass('hidden');
            var statusmessage = $('#status-message');
            statusmessage.append("<div class='alert " + divClass + "'>" + message + "</div>");
            statusmessage.removeClass('hidden');
            var remarks_div = $('#remark-' + expense_id);
            remarks_div.append(remarks);
            var leavebutton = $('#button-' + expense_id);


            leavebutton.empty();
            leavebutton.append("<button type='button' class='btn " + buttonClass + " br2 btn-xs fs12' aria-expanded='false'><i class='fa " + buttonIcon + "'>" + buttonText + "</i> </button>");
            setTimeout(function () {
                $('#approveModal').modal('hide');
            }, 4000);


        }
    });
});

$('.paidClick').click(function () {
    var instId = $(this).data('id');
    var type = $(this).data('name');

    var token = $('#token').val();
    $('#inst_id').val(instId);
    $('#type').val(type);

    $('#status-message').hide();
    $('#remarkModal').modal('show');

});
$('body').off('click', '.unpaidClick');
$('.unpaidClick').click(function () {
    var instId = $(this).data('id');
    var token = $('#token').val();

    $('#inst_id').val(instId);
    $('#status-message').hide();
    $('#remarkModal').modal('show');

});

$('#approve-button').click(function () {
    $('#loader').removeClass('hidden');

    var remarks = $('#remark-text').val();
    var type = $('#type').val();

    var inst_id = $('#inst_id').val();

    var token = $('#token').val();
    var message = '';
    var divClass = 'alert-success';
    var url = '/paid-installment';
    var buttonText = 'Paid';
    var buttonClass = 'btn-success';
    var buttonIcon = 'fa-check';

    if (type == 1) {
        message = 'Successfully Approved';
    } else {
        message = 'Ticket request rejected';
        divClass = 'alert-danger';
        url = '/unpaid-installment';
        buttonText = 'Unpaid';
        buttonClass = 'btn-danger';
        buttonIcon = 'fa-times';
    }

    $.post(url, {'instId': inst_id, 'remarks': remarks, '_token': token, 'paidType': type}, function (data) {
        var parsed = JSON.parse(data);
        if (parsed === 'success') {
            $('#loader').addClass('hidden');
            var statusmessage = $('#status-message');
            statusmessage.append("<div class='alert " + divClass + "'>" + message + "</div>");
            statusmessage.removeClass('hidden');
            var remarks_div = $('#remark-' + inst_id);
            remarks_div.append(remarks);
            var leavebutton = $('#button-' + inst_id);


            leavebutton.empty();
            leavebutton.append("<button type='button' class='btn " + buttonClass + " br2 btn-xs fs12' aria-expanded='false'><i class='fa " + buttonIcon + "'>" + buttonText + "</i> </button>");
            setTimeout(function () {
                $('#remarkModal').modal('hide');
            }, 4000);


        }
    });
});
//Payment skip clip
$('.skipClick').click(function () {
    var instId = $(this).data('id');
    var loanId = $(this).data('loan-id');
    $('#instal_id').val(instId);
    $("#loan_id").val(loanId);
    $('#skip-modal').modal('show');

});

$('#skipButton').click(function () {

    var inst_id = $('#instal_id').val();
    var loanId = $('#loan_id').val();
    var token = $('#token').val();
    var message = '';
    var divClass = 'alert-success';
    var url = '/skip-installment';
    message = 'Successfully skipped the installment';

    $.post(url, {'instId': inst_id, 'loanId': loanId, '_token': token}, function (data) {
        var parsed = JSON.parse(data);
        if (parsed === 'success') {
            $('#loader').addClass('hidden');
            var statusmessage = $('#status-message');
            statusmessage.append("<div class='alert " + divClass + "'>" + message + "</div>");
            statusmessage.removeClass('hidden');



            setTimeout(function () {
                window.location.reload();
            }, 1000);


        }
    });


});

$('body').off('click', '.visaClick');
$('.visaClick').click(function () {
    var visaId = $(this).data('id');
    var leaveId = $(this).data('leaveid');
    var reqstatus = $(this).data('status');
    var reqString = $(this).data('name');

    $('#req_id').val(visaId);
    $("#leave_id").val(leaveId);
    $("#reqStatus").val(reqstatus);
    $("#reqString").html(reqString);
    $('#skip-modal').modal('show');

});


$('body').off('click', '#reqestprocess');
$('#reqestprocess').click(function () {
    var reqStaus = $('#reqStatus').val();
    var leaveId = $('#leave_id').val();
    var requestId = $('#req_id').val();
    var token = $('#token').val();
    var message = '';
    var divClass = 'alert-success';
    var url = '/change-request-status';
    message = 'Successfully changed the status of request';

    $.post(url, {'reqId': requestId, 'leaveId': leaveId, '_token': token,'status':reqStaus}, function (data) {
        var parsed = JSON.parse(data);
        if (parsed === 'success') {
            $('#loader').addClass('hidden');
            var statusmessage = $('#success-message');
            statusmessage.append("<div class='alert " + divClass + "'>" + message + "</div>");
            statusmessage.removeClass('hidden');



            setTimeout(function () {
                window.location.reload();
            }, 1000);


        }
    });

});

$('body').off('click', '.hrClick');
$('.hrClick').click(function () {
    var visaId = $(this).data('id');
    var leaveId = $(this).data('leaveid');
    var reqstatus = $(this).data('status');
   

    $('#r_id').val(visaId);
    $("#leavereq_id").val(leaveId);
    $("#reqStatusnumber").val(reqstatus);

    $('#closeModal').modal('show');

});

$(document).off('focusout','#new_salary');
    $(document).on('focusout','#new_salary',function(){
         
         var basic_salary = ($.trim($(this).val()) !=='') ? $(this).val(): 0;
         var housing_allowance = (basic_salary > 0) ? (basic_salary *.25) :0;         
         $('#hra_salary').val(housing_allowance);
         var basic_salary = ($.trim($('#new_salary').val()) !=='') ? $('#new_salary').val(): 0;
          var housing_allowance = ($.trim($('#hra_salary').val()) !=='') ? $('#hra_salary').val(): 0;
          var total_salary = parseInt(basic_salary)+parseInt(housing_allowance);
          var gosi=0;
          var employerGosi =0;
         if($('#employee_type').val() == 0) {
          $('#employee_gosi').val(0);
          employerGosi = (total_salary > 0) ? (total_salary *.02) :0;
          $('#employer_gosi').val(employerGosi);
         
         } else {
           employerGosi = (total_salary > 0) ? (total_salary *.12) :0;
           gosi = (total_salary > 0) ? (total_salary *.10) :0;
           $('#employee_gosi').val(gosi);
           $('#employer_gosi').val(employerGosi);
          
         }
        
     });






  