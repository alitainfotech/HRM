/* ajax set up */
$.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    }
});
  
/* datatable */
var listing=$('#dataTableExample').DataTable({
    "aLengthMenu": [
        [10, 30, 50, -1],
        [10, 30, 50, "All"]
    ],
    "iDisplayLength": 10,
    "language": {
        search: ""
    },
    'ajax': {
        type:'POST',
        url: aurl + "/admin/review/listing", 
    },
    'columns': [
        { data: 'id' },
        { data: 'post' },
        { data: 'name' },
        { data: 'hr_review' },
        { data: 'hr_des' },
        { data: 'tl_review' },
        { data: 'tl_des' },
        { data: 'action' },
        
    ]
});
$('#dataTableExample').each(function() {
    var datatable = $(this);
    // SEARCH - Add the placeholder for Search and Turn this into in-line form control
    var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
    search_input.attr('placeholder', 'Search');
    search_input.removeClass('form-control-sm');
    // LENGTH - Inline-Form control
    var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
    length_sel.removeClass('form-control-sm');
});
$(document).ready(function(){

    /* reject the candidate */
    $('body').on("click", ".reject_candidate", function(event){
        event.preventDefault();
        var id = $(this).data('id');
        var a_id = $(this).data('a_id');
        const value  = Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, reject it!",
            cancelButtonText: "No, cancel!",
            input: "textarea",
            inputPlaceholder: "Why you want to reject...",
            inputAttributes: {
                "aria-label": "Type your message here",
            },
            showCancelButton: true,
            inputValidator: (value) => {
                return new Promise((resolve) => {
                    if (value) {
                        resolve();
                    } else {
                        resolve("reason is required!");
                    }
                });
            },
        }).then((result) => {
            if (result.isConfirmed) {
                var reason = result.value;
                $.ajax({
                    type: "post",
                    url: aurl + "/admin/review/reject",
                    data: {id: id,reason: reason,a_id: a_id},
                    dataType: "JSON",
                    success: function(data) {
                        toaster_message(data.message,data.icon,data.redirect_url);
                    },
                    error: function (error) {
                        toaster_message(error,'error',''); 
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                toaster_message('candidate is not rejected :)','error','');
            }
        });
    });
    /* select the candidate */
    $('body').on("click", ".select_candidate", function(event){
        event.preventDefault();
        var id = $(this).data('id');
        var a_id = $(this).data('a_id');
        const value  = Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "success",
            showCancelButton: true,
            confirmButtonText: "Yes, select it!",
            cancelButtonText: "No, cancel!",
            showCancelButton: true,
            input: "textarea",
            inputPlaceholder: "Why do you want to select...",
            inputAttributes: {
                "aria-label": "Type your message here",
            },
            showCancelButton: true,
            inputValidator: (value) => {
                return new Promise((resolve) => {
                    if (value) {
                        resolve();
                    } else {
                        resolve("reason is required!");
                    }
                });
            },
        }).then((result) => {
            if (result.isConfirmed) {
                var reason = result.value;
                $.ajax({
                    type: "post",
                    url: aurl + "/admin/review/select",
                    data: {id: id,a_id: a_id, reason:reason},
                    dataType: "JSON",
                    success: function(data) {
                        toaster_message(data.message,data.icon,data.redirect_url);
                    },
                    error: function (error) {
                        toaster_message(error,'error',''); 
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                toaster_message('candidate is not selected :)','error','');
            }
        });
    });
});