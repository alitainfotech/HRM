/* ajax set up */
$.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    }
});
  
/* datatable */

var listing = $('#dataTableExample').DataTable({
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
        url: aurl + "/admin/department/listing", 
    },
    'columns': [
        { data: 'id' },
        { data: 'name' },
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

    /* jquery validation for department form */
    $('#department_form').validate({
        rules: {
            name: {
                required: true
            },
        },
        messages: {
            name: "please enter your name",
        },
    });

    /* display add department modal */
    $('body').on("click", ".add_department", function(){
        $("#department_form").trigger('reset');
        $('#department_modal').modal('show');
        $('.id').val('0');
        $('#title_department_modal').text("Add department");
        $('.submit_value').text("Add department");
    });

    /* adding and updating department data */    
    $(".submit_value").on("click", function(event){
        event.preventDefault();
        var form = $('#department_form')[0];
        var formData = new FormData(form);
        if($("#department_form").valid()){   
            $.ajax({
                url: aurl + "/admin/department/store",
                type: 'POST',
                dataType: "JSON",
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
                success: function(data) {
                    $("#department_modal").modal("hide");
                    toaster_message(data.message,data.icon,data.redirect_url);
                },
            });
        } else {
            console.log('Please enter required fields!')
        }
    });

    /* display update department modal */
    $('body').on("click", ".department_edit", function(event){
        var id = $(this).data("id");
        $('.id').val(id);
        event.preventDefault();
        $.ajax({
            url: aurl + "/admin/department/show",
            type: "POST",
            data: {id:id},
            dataType: "JSON",
            success: function(data){
                if(data.status){
                    $("#department_form").trigger('reset');
                    $('#title_department_modal').text("Update department");
                    $('#department_modal').modal('show');
                    $('.submit_value').text("Update department");
                    $('.name').val(data.department_name.name);
                }else{
                    toaster_message(data.message,data.icon,data.redirect_url);
                }
            },
            error: function (error) {
                toaster_message('error','error','');
            }
        });
    });
    
    /* delete department */
    $('body').on("click", ".department_delete", function(event){
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
                    url: aurl + "/admin/department/delete",
                    data: {id: id},
                    dataType: "JSON",
                    success: function(data) {
                        toaster_message(data.message,data.icon,data.redirect_url);
                    },
                    error: function (error) {
                        toaster_message('error','error',''); 
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel ){
                toaster_message('Cancle deleting','error','');
            }
        })
    });
});