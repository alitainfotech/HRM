/* ajax set up */
$.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    }
});
function updateTextInput(val) {
    document.getElementById('textInput').value=val; 
}
/* datatable */
var listing=$('#dataTableExample').DataTable({
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
    url: aurl + "/admin/interview/listing", 
},
'columns': [
    { data: 'id' },
    { data: 'post' },
    { data: 'Interviewer' },
    { data: 'Interviewee' },
    { data: 'date' },
    { data: 'cv' },
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

    /* validation of interview form */
    $('#interview_form').validate({ 
        rules: {
            name: {
                required: true
            },
            leader: {
                required: true
            },
            date: {
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
            label.insertAfter(element);
            }
          },
        messages: {
            name: "please enter your name",
            leader: "please select team leader",
            date: "please chooce date for interview",
        },
    });
    $('#review_form').validate({ 
        rules: {
            review: {
                required: true,
                minlength: 1,
                maxlength: 10,
            },
            description: {
                required: true,
            }
        },
    });
    /* updating interview data in database */
    $(".submit_value").on("click", function(event){
        event.preventDefault();
        var form = $('#interview_form')[0];
        var formData = new FormData(form);
        if($("#interview_form").valid()){   
            $.ajax({
                url: aurl + "/admin/interview/store",
                type: 'POST',
                dataType: "JSON",
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
                success: function(data) {
                    $('#interview_form').modal('hide');
                    toaster_message(data.message,data.icon,data.redirect_url);
                },
                error: function (error) {
                    toaster_message(error,'error',''); 
                }
            });
        } else {
            console.log('Please enter required fields!')
        }
    });

    /* display update interview modal */
    $('body').on("click", ".edit_interview", function(event){
        var id = $(this).data("id");
        $('.i_id').val(id);
        event.preventDefault();
        $.ajax({
            url: aurl + "/admin/interview/show",
            type: "POST",
            data: {id:id},
            dataType: "JSON",
            success: function(data){
                if(data.status){
                    $("#interview_form").trigger('reset');
                    $('#interview_modal').modal('show');
                    $('#title_interview_modal').text("Add Interview");
                    $('.submit_value').val("Add interview");
                    $('.name').val(data.name);
                    $('.leader option[value="'+data.id+'"]').prop('selected', true);
                    var dateArr = data.date.split(' ');
                    date = dateArr[0]+'T'+dateArr[1];
                    $('.date').val(date);
                    $('.leader').select2({
                        dropdownParent: $('#interview_modal')
                    });
                }else{
                    toaster_message(data.message,data.icon,data.redirect_url);
                }
            },
            error: function (error) {
                toaster_message('error','error',''); 
            }
        });
    });
    
    /* reject the application */
    $('body').on("click", ".reject", function(event){
        event.preventDefault();
        var id = $(this).data('id');
        var i_id = $(this).data('i_id');
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
                    data: {id: id,reason: reason,i_id: i_id},
                    dataType: "JSON",
                    beforeSend: function() {
                        $('body').removeClass('loaded');
                    },
                    success: function(data) {
                        $('body').addClass('loaded');
                        toaster_message(data.message,data.icon,data.redirect_url);
                    },
                    error: function (error) {
                        toaster_message(error,'error',''); 
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                toaster_message('Cancle rejecting application','error','');
            }
        });
    });

    /* display add review modal */
    $("body").on("click", ".add_review", function () {
        var id = $(this).data("i_id");
        $(".i_id").val(id);
        $("#review_form").trigger("reset");
        $("#review_modal").modal("show");
        $("#title_review_modal").text("Add Review");
        $(".submit_value").val("Add Review");
    });

    /* adding review data in database */
    $(".submit_review").on("click", function(event){
        event.preventDefault();
        var form = $('#review_form')[0];
        var formData = new FormData(form);
        if($("#review_form").valid()){   
            $.ajax({
                url: aurl + "/admin/review/store",
                type: 'POST',
                dataType: "JSON",
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
                success: function(data) {
                    if(data.status){
                        $('#review_modal').modal('hide');
                    }else{
                        toaster_message(data.message,data.icon,data.redirect_url);
                    }
                },
                error: function (error) {
                    toaster_message(error,'error',''); 
                }
            });
        } else {
            console.log('Please enter required fields!')
        }
    });
});