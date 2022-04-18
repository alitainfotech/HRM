/* ajax set up */
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="_token"]').attr("content"),
    },
});

/* datatable */
$(function () {
    "use strict";
    $(function () {
        $("#dataTableExample").DataTable({
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
                { data: "post" },
                { data: "name" },
                { data: "phone" },
                { data: "email" },
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
    });
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
                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: "btn btn-success",
                            cancelButton: "btn btn-danger me-2",
                        },
                        buttonsStyling: false,
                    });
                    swalWithBootstrapButtons.fire(
                        "Cancelled",
                        data.message,
                        "error"
                    );
                }
            },
            error: function (error) {
                alert("error; " + eval(error));
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
                    if (data.status) {
                        $("#interview_form").modal("hide");
                        window.location.href = aurl + "/admin/interview";
                    } else {
                        const swalWithBootstrapButtons = Swal.mixin({
                            customClass: {
                                confirmButton: "btn btn-success",
                                cancelButton: "btn btn-danger me-2",
                            },
                            buttonsStyling: false,
                        });
                        swalWithBootstrapButtons.fire(
                            "Cancelled",
                            data.message,
                            "error"
                        );
                    }
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
                    url: aurl + "/admin/application/pending/reject",
                    data: {id: id,reason: reason},
                    dataType: "JSON",
                    success: function(data) {
                        if(data.status){
                            swal.fire({
                                title: 'rejected!',
                                text: "Application is rejected",
                                icon: 'success',
                                confirmButtonText: 'OK',
                                reverseButtons: true
                            }).then((result) => {
                                if(result.value){
                                    window.location.href = aurl + "/admin/application/pending";
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
                swal.fire("Cancelled", "Application is pending :)", "info");
            }
        });
    });
});