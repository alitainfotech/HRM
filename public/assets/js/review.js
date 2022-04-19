/* ajax set up */
$.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    }
});
  
/* datatable */
$(function() {
    'use strict';
    $(function() {
        $('#dataTableExample').DataTable({
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
    });
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
                        if(data.status){
                            swal.fire({
                                title: 'rejected!',
                                text: "Candidate is rejected",
                                icon: 'success',
                                confirmButtonText: 'OK',
                                reverseButtons: true
                            }).then((result) => {
                                if(result.value){
                                    window.location.href = aurl + "/admin/review";
                                }
                            })
                        }else{
                            swal.fire('Cancelled',data.message,'error')
                        }
                    },
                    error: function (error) {
                        alert('error; ' + eval(error));
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swal.fire("Cancelled", "candidate is not rejected :)", "info");
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
        }).then((result) => {
            if (result.isConfirmed) {
                var reason = result.value;
                $.ajax({
                    type: "post",
                    url: aurl + "/admin/review/select",
                    data: {id: id,a_id: a_id},
                    dataType: "JSON",
                    success: function(data) {
                        if(data.status){
                            swal.fire({
                                title: 'selected!',
                                text: "Candidate is selected",
                                icon: 'success',
                                confirmButtonText: 'OK',
                                reverseButtons: true
                            }).then((result) => {
                                if(result.value){
                                    window.location.href = aurl + "/admin/review";
                                }
                            })
                        }else{
                            swal.fire('Cancelled',data.message,'error')
                        }
                    },
                    error: function (error) {
                        alert('error; ' + eval(error));
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swal.fire("Cancelled", "candidate is not selected :)", "info");
            }
        });
    });
});