$(document).ready(function () {
    $('#reset').validate({ 
        rules: {
            email: {
                required: true,
                email: true,
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
    
});