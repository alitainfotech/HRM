

/* ajax set up */
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    }
});

/* datatable */
$(function () {
    'use strict';
    $(function () {
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
                type: 'POST',
                url: aurl + "/application/listing",
            },
            'columns': [
                { data: 'id' },
                { data: 'title' },
                { data: 'date' },
                { data: 'experience' },
                { data: 'status' },
                { data: 'action' },

            ]
        });
        $('#dataTableExample').each(function () {
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

$(document).ready(function () {

    $('#application_form').validate({ // initialize the plugin
        rules: {
            name: {
                required: true
            },
            email: {
                required: true,
                email: true,
            },
            password: {
                required: true,
                minlength: 8,
                pwcheck: true
            },
            phone: {
                required: true,
                minlength: 10,
                maxlength: 10,
                digits: true
            },
            cv: {
                required: true,
                extension: "pdf|docx"
            },
            description: {
                required: true
            },
            experience_month: {
                required: true,
                minlength: 1,
                maxlength: 10,
                digits: true
            },
            experience_year: {
                required: true,
                minlength: 1,
                maxlength: 10,
                digits: true
            },
        },
        messages: {
            fullname: "Please enter your full name",
            email: {
                required: "Please enter a valid email address",
                emailcheck: "Please register with another email id"
            },
            phone: {
                required: "Please enter your phone number",
                minlength: "Your phone must be 10 characters long",
                maxlength: "Your phone must be 10 characters only"
            },
            cv: {
                required: "Please upload your cv",
                extension: "Please upload pdf or docx file only",
            },
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 8 characters long",
                pwcheck: "please enter atleast one uppercase, number and special character!"
            },
        },
    });

    /* display add application modal */
    $('body').on("click", ".apply_job", function () {
        $('.already-exist').text('');
        var id = $(this).data("id");
        $('.o_id').val(id);
        $("#application_form").trigger('reset');
        $('#application_modal').modal('show');
        $('#title_application_modal').text("Application");
        $('.submit_value').val("Add Application");
        $('.post').select2({
            dropdownParent: $('#application_modal')
        });
    });

    /* adding and updating application data */
    $(".submit_value").on("click", function (event) {
        event.preventDefault();
        $('.already-exist').text('');
        var form = $('#application_form')[0];
        var formData = new FormData(form);
        if ($("#application_form").valid()) {
            $.ajax({
                url: aurl + "/application/store",
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data.status == 0) {
                        $('.already-exist').text(data.message);
                    } else {
                        $('#application_form').modal('hide');
                        window.location.href = aurl + "/dashboard";
                    }
                },
            });
        } else {
            console.log('Please enter required fields!')
        }
    });

    /* display update application modal */
    $('body').on("click", ".application_edit", function (event) {
        var id = $(this).data("id");
        $('.id').val(id);
        // alert(id);
        event.preventDefault();
        $.ajax({
            url: aurl + "/candidate/application/show",
            type: "POST",
            data: { id: id },
            dataType: "JSON",
            success: function (data) {
                $("#application_form").trigger('reset');
                $('#title_application_modal').text("Update application");
                $('#application_modal').modal('show');
                $('.submit_value').val("Update application");
                $('.post').select2({
                    dropdownParent: $('#application_modal')
                });
                var experience = data.experience.split('-');
                $('.phone').val(data.candidate.phone);
                $('.description').val(data.description);
                $('.post option[value="' + data.post + '"]').prop('selected', true);
                $('.post').trigger('change');
                $('.experience_year').val(experience[0]);
                $('.experience_month').val(experience[1]);
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

    $('body').on("click", ".application_delete", function (event) {
        event.preventDefault();
        var id = $(this).data('id');
        // alert(id);
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
                    url: aurl + "/candidate/application/delete",
                    data: { id: id },
                    success: function (data) {
                        swalWithBootstrapButtons.fire({
                            title: 'Deleted!',
                            text: "Your file has been deleted.",
                            icon: 'success',
                            confirmButtonText: 'OK',
                            reverseButtons: true
                        }).then((result) => {
                            if (result.value) {
                                window.location.href = aurl + "/candidate";
                            }
                        })
                    },
                    error: function (error) {
                        // alert('error; ' + eval(error));
                        swalWithBootstrapButtons.fire(
                            'Cancelled',
                            'this data is not available for delete:)',
                            'error'
                        )
                    }
                });

            } else if (
                // Read more about handling dismissals
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                    'Cancelled',
                    'Your data is safe :)',
                    'error'
                )
            }
        })
    });

    $(document).on('click', '.show-reason', function () {
        $("#show_reason").modal("show");
        let reason = $(this).data('reason');
        $('#reject_reason').text(reason);
    });


});