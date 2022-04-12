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
        url: aurl + "/admin/user/listing", 
    },
    'columns': [
        { data: 'full_name' },
        { data: 'email' },
        { data: 'designation' },
        { data: 'role' },
        { data: 'j_date' },
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


    $('#user_form').validate({ // initialize the plugin
        rules: {
            role: {
                required: true
            },
            department: {
                required: true
            },
            fullname: {
                required: true
            },
            u_email: {
                required: true,
                email: true,
                emailcheck: true,
            },
            password: {
                required: true,
                minlength: 8,
                pwcheck: true
            },
            designation: {
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
            label.insertAfter(element); // standard behaviour
            }
          },
        messages: {
            role: "please select a role",
            department: "please select a department",
            fullname: "Please enter your full name",
            title: "Please enter title",
            u_email: {
                required: "Please enter a valid email address",
                emailcheck: "Please register with another email id"
            },
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 8 characters long",
                pwcheck: "please enter atleast one uppercase, number and special character!"
            },
            designation: "Please enter designation of user!"

        },
    });
    $.validator.addMethod("pwcheck",function(value, element) {
        return (value.match(/[a-z]/) && value.match(/[A-Z]/) && value.match(/[0-9]/) && value.match(/[_!#@$%^&*]/));
    }, 'Please enter a valid password');
    $.validator.addMethod("emailcheck",function(value) { 
    var x = 0;
    var x = $.ajax({
        url: aurl + "/admin/user/emailcheck",
        type: 'POST',
        async: false,
        data: {email:value},
    }).responseText; 
    if (x != 0){ return false; }else return true;
    }, 'Please register with another email id');
  /* display add job opening modal */
  $('body').on("click", ".add_user", function(){
          $('#user_modal').modal('show');
          $('.id').val('0');
          $('#title_user_modal').text("Add User");
          $('.submit_value').text("Add User");
          $("#user_form").trigger('reset');
          $('.form-select').select2({
              dropdownParent: $('#user_modal')
          });
      });

  /* adding and updating job opening data */    
    $(".submit_value").click(function(event){
        event.preventDefault();
        var form = $('#user_form')[0];
        var formData = new FormData(form);
        if($("#user_form").valid()){   
            $.ajax({
                url: aurl + "/admin/user/store",
                type: 'POST',
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
                success: function(data) {
                    window.location.href = aurl + "/admin/user";
                },
            });
        } else {
            console.log('Please enter required fields!')
        }
     
    });

  /* display update user modal */
  $('body').on("click", ".user_edit", function(event){
      var id = $(this).data("id");
      $('.id').val(id);
      event.preventDefault();
      $.ajax({
          url: aurl + "/admin/user/show",
          type: "POST",
          data: {id:id},
          dataType: "JSON",
          success: function(data){
              $("#user_form").trigger('reset');
              $('#title_user_modal').text("Update User");
              $('#user_modal').modal('show');
              $('.submit_value').text("Update User");
              $('.full_name').val(data.full_name);
              $('.email').val(data.email);
              $('#role option[value="'+data.role_id+'"]').prop('selected', true);
              $('.designation').val(data.designation);
              $('.role').select2({
                  dropdownParent: $('#user_modal')
              });
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
  
  $('body').on("click", ".user_delete", function(event){
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
                  url: aurl + "/admin/user/delete",
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
                              window.location.href = aurl + "/admin/user";
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

 
});