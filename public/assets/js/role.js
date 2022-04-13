

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
            url: aurl + "/admin/role/listing", 
        },
        'columns': [
            { data: 'id' },
            { data: 'title' },
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

    /* validation for role form */
    $('#role_form').validate({ 
        rules: {
            title: {
                required: true
            },
            "permission[]":"required",
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
            label.insertAfter(element); // standard behaviour
            }
          },
        messages: {
            title: "please enter title",
            "permission[]": "Please select permission for role!",
        },
    });

    /* display add role modal */
    $('body').on("click", ".add_role", function(){
        $("#role_form").trigger('reset');
        $('#role_modal').modal('show');
        $('.id').val('0');
        $('#title_role_modal').text("Add Role");
        $('.submit_value').text("Add Role");
        $('.permission').select2({
            dropdownParent: $('#role_modal')
        });
    });

    /* adding and updating role data */    
    $(".submit_value").on("click", function(event){
        event.preventDefault();
        console.log(event);
        var form = $('#role_form')[0];
        var formData = new FormData(form);
        if($("#role_form").valid()){   
            $.ajax({
                url: aurl + "/admin/role/store",
                type: 'POST',
                dataType: "JSON",
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
                success: function(data) {
                    console.log(data)
                    if(data.status){
                        $('#role_modal').modal('hide');
                        window.location.href = aurl + "/admin/role";
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
            });
        } else {
            console.log('Please enter required fields!')
        }
    });

    /* display update role modal */
    $('body').on("click", ".role_edit", function(event){
        var id = $(this).data("id");
        $('.id').val(id);
        event.preventDefault();
        $.ajax({
            url: aurl + "/admin/role/show",
            type: "POST",
            data: {id:id},
            dataType: "JSON",
            success: function(data){
                if(data.responce.status){
                    $("#role_form").trigger('reset');
                    $('#title_role_modal').text("Update role");
                    $('#role_modal').modal('show');
                    $('.submit_value').text("Update role");
                    $('.permission').select2({
                        dropdownParent: $('#role_modal')
                    });
                    $('.title').val(data.permission.title);
                    var p_id_ar = data.permission.p_id;
                    $.each(p_id_ar, function( index, value ) {
                        $('.permission option[value="'+value+'"]').prop('selected', true);
                    });
                    $('.permission').trigger('change');
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
                        data.responce.message,
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
                    'this data is not available for update :)',
                    'error'
                )
            }
        });
    });
    
    /* deleteing role */
    $('body').on("click", ".role_delete", function(event){
        event.preventDefault();
        var id = $(this).data('id');
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
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
            }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "post",
                    dataType: "JSON",
                    url: aurl + "/admin/role/delete",
                    data: {id: id},
                    success: function(data) {
                        if(data.status){
                            swalWithBootstrapButtons.fire({
                                title: 'Deleted!',
                                text: "Your file has been deleted.",
                                icon: 'success',
                                confirmButtonText: 'OK',
                                reverseButtons: true
                            }).then((result) => {
                                if(result.value){
                                    window.location.href = aurl + "/admin/role";
                                }
                            })
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
                        swalWithBootstrapButtons.fire(
                            'Cancelled',
                            'this data is not available for delete:)',
                            'error'
                        )
                    }
                });
            }else if(result.dismiss === Swal.DismissReason.cancel){
                swalWithBootstrapButtons.fire(
                'Cancelled',
                'Your data is safe :)',
                'error'
                )
            }
        })
    });
});