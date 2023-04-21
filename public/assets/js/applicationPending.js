/* ajax set up */
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="_token"]').attr("content"),
    },
});

/* datatable */

var listing = $("#dataTableExample").DataTable({
    aLengthMenu: [
        [10, 30, 50, -1],
        [10, 30, 50, "All"],
    ],
    iDisplayLength: 10,
    language: {
        search: "",
    },
    ajax: {
        type: "POST",
        url: aurl + "/admin/application/pending/listing",
    },
    columns: [
        { data: "id" },
        { data: "name" },
        { data: "phone" },
        { data: "email" },
        { data: "post" },
        { data: "cv" },
        { data: "description" },
        { data: "experience" },
        { data: "action" },
    ],
});
$("#dataTableExample").each(function () {
    var datatable = $(this);
    // SEARCH - Add the placeholder for Search and Turn this into in-line form control
    var search_input = datatable
        .closest(".dataTables_wrapper")
        .find("div[id$=_filter] input");
    search_input.attr("placeholder", "Search");
    search_input.removeClass("form-control-sm");
    // LENGTH - Inline-Form control
    var length_sel = datatable
        .closest(".dataTables_wrapper")
        .find("div[id$=_length] select");
    length_sel.removeClass("form-control-sm");
});

$(document).ready(function () {
    $("#interview_form").validate({
        // initialize the plugin
        rules: {
            name: {
                required: true,
            },
            leader: {
                required: true,
            },
            date: {
                required: true,
            },
        },
        errorPlacement: function (label, element) {
            if (element.attr("type") == "radio") {
                label.insertAfter(element.closest(".form-check"));
            } else if (element.attr("type") == "checkbox") {
                label.insertAfter(element.closest(".form-check"));
            } else if (element.is("select")) {
                label.insertAfter(element.closest(".select"));
            } else {
                label.insertAfter(element); // standard behaviour
            }
        },
        messages: {
            name: "please enter your name",
            leader: "please select team leader",
            date: "please chooce date for interview",
        },
    });

    /* display add interview modal */
    $("body").on("click", ".add_interview", function () {
        var id = $(this).data("id");
        $(".id").val(id);
        $.ajax({
            url: aurl + "/admin/application/pending/name/show",
            type: "POST",
            data: { id: id },
            dataType: "JSON",
            success: function (data) {
                if (data.status) {
                    $("#interview_form").trigger("reset");
                    $("#interview_modal").modal("show");
                    $("#title_interview_modal").text("Add Interview");
                    $(".submit_value").val("Add interview");
                    $(".name").val(data.name);
                    $(".leader").select2({
                        dropdownParent: $("#interview_modal"),
                    });
                } else {
                    toaster_message(data.message, data.icon, data.redirect_url);
                }
            },
        });
    });

    /* adding interview data */
    $(".submit_value").on("click", function (event) {
        event.preventDefault();
        var form = $("#interview_form")[0];
        var formData = new FormData(form);
        if ($("#interview_form").valid()) {
            $.ajax({
                url: aurl + "/admin/interview/store",
                type: "POST",
                dataType: "JSON",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    $("#interview_modal").modal("hide");
                    toaster_message(data.message, data.icon, data.redirect_url);
                },
                error: function (error) {
                    alert("error; " + eval(error));
                },
            });
        } else {
            console.log("Please enter required fields!");
        }
    });

    $("body").on("click", ".reject", function (event) {
        event.preventDefault();
        var id = $(this).data("id");
        const value = Swal.fire({
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
                    url: aurl + "/admin/application/pending/reject",
                    data: { id: id, reason: reason },
                    dataType: "JSON",
                    beforeSend: function () {
                        $('body').removeClass('loaded');
                    },
                    success: function (data) {
                        $('body').addClass('loaded');
                        toaster_message(data.message, data.icon, data.redirect_url);
                    },
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swal.fire("Cancelled", "Application is pending :)", "info");
            }
        });
    });

    /* display update interview modal */
    $('body').on("click", ".edit_interview", function (event) {
        var id = $(this).data("id");
        $('.i_id').val(id);
        event.preventDefault();
        $.ajax({
            url: aurl + "/admin/interview/show",
            type: "POST",
            data: { id: id },
            dataType: "JSON",
            success: function (data) {
                if (data.status) {
                    $("#interview_form").trigger('reset');
                    $('#interview_modal').modal('show');
                    $('#title_interview_modal').text("Update Interview");
                    $('.submit_value').val("Update interview");
                    $('.name').val(data.name);
                    $('.leader option[value="' + data.id + '"]').prop('selected', true);
                    var dateArr = data.date.split(' ');
                    date = dateArr[0] + 'T' + dateArr[1];
                    $('.date').val(date);
                    $('.leader').select2({
                        dropdownParent: $('#interview_modal')
                    });
                } else {
                    toaster_message(data.message, data.icon, data.redirect_url);
                }
            },
            error: function (error) {
                toaster_message('error', 'error', '');
            }
        });
    });
});
