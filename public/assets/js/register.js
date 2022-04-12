$(document).ready(function () {
    $('#registration').validate({ // initialize the plugin
        rules: {
            fullname: {
                required: true
            },
            email: {
                required: true,
                email: true,
                emailcheck: true,
            },
            password: {
                required: true,
                minlength: 8,
                pwcheck: true
            },
        },
        messages: {
            fullname: "Please enter your full name",
            email: {
              required: "Please enter a valid email address",
              emailcheck: "Please register with another email id"
            },
            password: {
              required: "Please provide a password",
              minlength: "Your password must be at least 8 characters long",
              pwcheck: "please enter atleast one uppercase, number and special character!"
            },
          },
    });
    $.validator.addMethod("pwcheck",function(value, element) {
        return (value.match(/[a-z]/) && value.match(/[A-Z]/) && value.match(/[0-9]/) && value.match(/[_!#@$%^&*]/));
    }, 'Please enter a valid password');
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    }
    });
    $.validator.addMethod("emailcheck",function(value) { 
    var x = 0;
    var x = $.ajax({
        url: aurl + "/candidate/emailcheck",
        type: 'POST',
        async: false,
        data: {email:value},
    }).responseText; 
    if (x != 0){ return false; }else return true;
    }, 'Please register with another email id');
});