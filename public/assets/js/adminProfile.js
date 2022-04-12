$.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    }
  });
$(document).ready(function(){

    $('#profile_form').validate({ // initialize the plugin
        rules: {
            name: {
                required: true
            },
            email: {
                required: true
            },
            phone: {
                minlength: 10,
                maxlength: 10,
                digits: true
            },
            image: {
                extension: "png|jpeg|jpg"
            }
           
        },
        messages: {
            name: "please enter your name",
            email: "please enter your email",
        },
    });

    $('body').on("click", ".edit_profile", function(){
        $("#profile_form").trigger('reset');
        $('#profile_modal').modal('show');
        $('#title_profile_modal').text("Edit your profile");
        $('.submit_value').val("Update profile");
    });
    $(".submit_value").on("click", function(event){
        event.preventDefault();
        console.log(event);
        var form = $('#profile_form')[0];
        var formData = new FormData(form);
        if($("#profile_form").valid()){   
            $.ajax({
                url: aurl + "/candidate/profile/update",
                type: 'POST',
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
                success: function(data) {
                    $('#profile_modal').modal('hide');
                    // window.location.href = aurl + "/candidate/profile";
                },
            });
        } else {
            console.log('Please enter required fields!')
        }
    });
});