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
            url: aurl + "/admin/interview/listing", 
        },
        'columns': [
            { data: 'id' },
            { data: 'post' },
            { data: 'Interviewer' },
            { data: 'Interviewee' },
            { data: 'date' },
            { data: 'cv' },
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

    /* validation of interview form */
    $('#interview_form').validate({ 
        rules: {
            name: {
                required: true
            },
            leader: {
                required: true
            },
            date: {
                required: true
            },
        },
        errorPlacement: function (label, element) {
            if(element.attr("type") == "radio" )
            {
              label.insertAfter(element.closest(".form-check")); 
            }
            else if(element.attr("type") == "checkbox"){
            label.insertAfter(element.closest(".form-check")); 
            }
            else if(element.is('select') ){
              label.insertAfter(element.closest(".select"));
            }
            else 
            {
            label.insertAfter(element);
            }
          },
        messages: {
            name: "please enter your name",
            leader: "please select team leader",
            date: "please chooce date for interview",
        },
    });
    
    /* updating interview data in database */
    $(".submit_value").on("click", function(event){
        event.preventDefault();
        var form = $('#interview_form')[0];
        var formData = new FormData(form);
        if($("#interview_form").valid()){   
            $.ajax({
                url: aurl + "/admin/interview/store",
                type: 'POST',
                dataType: "JSON",
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
                success: function(data) {
                    if(data.status){
                        $('#interview_form').modal('hide');
                        window.location.href = aurl + "/admin/interview";
                    }else{
                        const swalWithBootstrapButtons = Swal.mixin({
                            customClass: {
                                confirmButton: 'btn btn-success',
                                cancelButton: 'btn btn-danger me-2'
                            },
                            buttonsStyling: false,
                        })
                        swalWithBootstrapButtons.fire(
                            'Cancelled',
                            data.message,
                            'error'
                        )
                    }
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
                        'this application is not available for interview :)',
                        'error'
                    )
                }
            });
        } else {
            console.log('Please enter required fields!')
        }
    });

    /* display update interview modal */
    $('body').on("click", ".edit_interview", function(event){
        var id = $(this).data("id");
        $('.i_id').val(id);
        event.preventDefault();
        $.ajax({
            url: aurl + "/admin/interview/show",
            type: "POST",
            data: {id:id},
            dataType: "JSON",
            success: function(data){
                if(data.status){
                    $("#interview_form").trigger('reset');
                    $('#interview_modal').modal('show');
                    $('#title_interview_modal').text("Add Interview");
                    $('.submit_value').val("Add interview");
                    $('.name').val(data.name);
                    $('.leader option[value="'+data.id+'"]').prop('selected', true);
                    var dateArr = data.date.split(' ');
                    date = dateArr[0]+'T'+dateArr[1];
                    $('.date').val(date);
                    $('.leader').select2({
                        dropdownParent: $('#interview_modal')
                    });
                }else{
                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-success',
                            cancelButton: 'btn btn-danger me-2'
                        },
                        buttonsStyling: false,
                        })
                    swalWithBootstrapButtons.fire(
                        'Cancelled',
                        data.message,
                        'error'
                    )
                
                }
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
                    'this data is not available for access :)',
                    'error'
                )
            }
        });
    });
    
    /* reject the application */
    $('body').on("click", ".reject", function(event){
        event.preventDefault();
        var id = $(this).data('id');
        var i_id = $(this).data('i_id');
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger me-2'
            },
            buttonsStyling: false,
            })
            
            swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, reject it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
            }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "post",
                    url: aurl + "/admin/application/reject",
                    data: {id: id,i_id: i_id},
                    success: function(data) {
                        swalWithBootstrapButtons.fire({
                            title: 'rejected!',
                            text: "Application is rejected",
                            icon: 'success',
                            confirmButtonText: 'OK',
                            reverseButtons: true
                        }).then((result) => {
                            if(result.value){
                                window.location.href = aurl + "/admin/interview";
                            }
                        })
                    },
                    error: function (error) {
                        swalWithBootstrapButtons.fire(
                            'Cancelled',
                            'this data is not available for delete:)',
                            'error'
                        )
                    }
                });
            }else if (result.dismiss === Swal.DismissReason.cancel){
                swalWithBootstrapButtons.fire(
                'Cancelled',
                'Your data is safe :)',
                'error'
                )
            }
        })
    });
});