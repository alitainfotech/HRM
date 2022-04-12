$(function() {
    'use strict';
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
    });
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
          url: aurl + "/admin/opening/listing", 
      },
      'columns': [
        { data: 'technology' },
        { data: 'id' },
        { data: 'title' },
        { data: 'description' },
        { data: 'number_openings' },
        { data: 'remaining' },
        { data: 'min_experience' },
        { data: 'max_experience' },
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

    $('#job_opening_form').validate({ // initialize the plugin
        rules: {
            title: {
                required: true
            },
            number_openings: {
                required: true,
                minlength: 1,
                maxlength: 10,
                digits: true
            },
            min_experience:{
                required: true,
                minlength: 1,
                maxlength: 10,
                digits: true
            },
              max_experience:{
                required: true,
                minlength: 1,
                maxlength: 10,
                digits: true
            },
            icon: {
                required: true,
                extension: "png|jpeg|jpg"
            },
            description: {
                required: true
            },
        },
        messages: {
            title: "Please enter title",
            icon: {
                required: "Please upload your icon",
                extension: "Please upload png, jpg or jpeg file"
              },
          },
    });

    /* display add job opening modal */
    $('body').on("click", ".add_job_opening", function(){
            $('#job_opening_modal').modal('show');
            $('.id').val('0');
            $('#title_job_opening_modal').text("Add job Opening");
            $('.submit_value').text("Add job");
            $("#job_opening_form").trigger('reset');
            $('.technology').select2({
                dropdownParent: $('#job_opening_modal')
            });
        });

    /* adding and updating job opening data */    
    $(".submit_value").click(function(event){
        event.preventDefault();
        var form = $('#job_opening_form')[0];
        var formData = new FormData(form);
        if($("#job_opening_form").valid()){   
            $.ajax({
                url: aurl + "/admin/opening/store",
                type: 'POST',
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
                success: function(data) {
                    window.location.href = aurl + "/admin/opening";
                },
            });
        } else {
            console.log('Please enter required fields!')
        }
       
    });

    /* display update job modal */
    $('body').on("click", ".job_edit", function(event){
        var id = $(this).data("id");
        $('.id').val(id);
        event.preventDefault();
        $.ajax({
            url: aurl + "/admin/opening/show",
            type: "POST",
            data: {id:id},
            dataType: "JSON",
            
            success: function(data){
                $("#job_opening_form").trigger('reset');
                $('#title_job_opening_modal').text("Update job Opening");
                $('#job_opening_modal').modal('show');
                $('.submit_value').text("Update job");
                $('.title').val(data.title);
                $('.description').val(data.description);
                if(data.fresher==1){
                    $('#fresher').prop('checked', true);
                    $('.experience').hide();
                }
                $('.min_experience').val(data.min_experience);
                $('.max_experience').val(data.max_experience);
                $('.number_openings').val(data.number_openings);


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
    
    $('body').on("click", ".job_delete", function(event){
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
                    url: aurl + "/admin/opening/delete",
                    data: {id: id},
                    success: function(data) {
                        swalWithBootstrapButtons.fire({
                            title: 'Deleted!',
                            text: "Your file has been deleted.",
                            icon: 'success',
                            confirmButtonText: 'OK',
                            reverseButtons: true
                        }).then((result) => {
                            if(result.value){
                                console.log(data);
                                window.location.href = aurl + "/admin/opening";
                            }
                        })
                        
                    },
                    error: function (error) {
                        // alert('error; ' + eval(error));
                        swalWithBootstrapButtons.fire(
                            'Cancelled',
                            'this data is not available :)',
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
                'Your data file is safe :)',
                'error'
                )
            }
        })
    });
    $('#fresher').change(function() {
        if(this.checked) {
            $('.experience').hide();
        }else{
            $('.experience').show();
        }      
    });
   
});