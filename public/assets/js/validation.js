var FormValidation = function () {
  return {
      init: function () {
        
          $("form[name='registration']").validate({
              errorClass: "error",
              ignore: ':hidden',
              ignore: [],
             
              rules: {
                
                fullname: "required",
                checked:"required",
                name:"required",
                phone: {
                  required: true,
                  minlength: 10,
                  maxlength: 10,
                },
                cv:"required",
                "technology[]":"required",
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
                post:"required",
                icon:"required",
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
                title: "required",
                description: "required",
                number_openings: {
                  required: true,
                  minlength: 1,
                  maxlength: 10,
                  digits: true
                },
                "role[]":"required",
                role:"required",
                designation:"required",
                u_email: {
                  required: true,
                  email: true,
                  u_emailcheck: true
                },
                leader:"required",
                date:"required",
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
                // else if(element.attr("type") == "password" ||element.attr("type") == "confirm_password"){
                //   label.insertAfter(element.closest(".input-group")); 
                //   }
                else 
                {
                label.insertAfter(element); // standard behaviour
                }
              },
              invalidHandler: function (event, validator) {
                for (var i=0;i<validator.errorList.length;i++){
                   console.log(validator.errorList[i]);
               }
              },
              
              
              messages: {
                fullname: "Please enter your full name",
                
                phone: {
                  required: "Please enter your phone number",
                  minlength: "Your phone must be 10 characters long",
                  maxlength:"Your phone must be 10 characters only"
                },
                email: {
                  required: "Please enter a valid email address",
                  emailcheck: "Please register with another email id"
                },
                password: {
                  required: "Please provide a password",
                  minlength: "Your password must be at least 8 characters long",
                  pwcheck: "please enter atleast one uppercase, number and special character!"
                },
                name: "Please enter name",
                cv: "Please enter your cv",
                "technology[]": "Please select your technology",
                experience: "Please enter your experience",
                post: "Please select your post",
              },
             
             
              submitHandler: function(form) {
                form.submit();
              }
              
          });

          $.validator.addMethod("pwcheck",
          function(value, element) {
            return (value.match(/[a-zA-Z]/) && value.match(/[0-9]/) && value.match(/[_!#@$%^&*]/));
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
          // $.validator.addMethod("u_emailcheck",function(value) { 
          //   var x = 0;
          //   var x = $.ajax({
          //     url: aurl + "/user/emailcheck",
          //     type: 'POST',
          //     async: false,
          //     data: {email:value},
          //   }).responseText;
          //   if (x != 0){ return false; }else return true;
          // }, 'Please register with another email id');

          
      }
  };
}();