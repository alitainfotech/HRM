/* ajax set up */
$.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    }
});

$(document).ready(function(){
    $.ajax({
        url: aurl + "/admin/dashboard/value",
        type: 'POST',
        dataType: "JSON",
        cache:false,
        contentType: false,
        processData: false,
        success: function(data) {
            $('.active_openings').html(data.openings_active);
            $('.active_users').html(data.users_active);
            $('.inactive_users').html(data.users_inactive);
            $('.pending_applications').html(data.application_pending);
            $('.reviewed_applications').html(data.application_reviewed);
            $('.rejected_applications').html(data.application_rejected);
            $('.selected_applications').html(data.application_selected);
            $('.active_interviews').html(data.interviews_active);
            $('.inactive_interviews').html(data.interviews_inactive);
        },
        error: function (error) {
            alert('error; ' + eval(error));
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger me-2'
                },
                buttonsStyling: false,
                })
            swalWithBootstrapButtons.fire(
                'Cancelled',
                'this data is not valid :)',
                'error'
            )
        }
    });
   
});