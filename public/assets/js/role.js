

/* ajax set up */
$.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    }
});
  
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
        url: aurl + "/admin/role/listing", 
    },
    'columns': [
        { data: 'id' },
        { data: 'title' },
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

    /* validation for role form */
    $('#role_form').validate({ 
        rules: {
            title: {
                required: true
            },
            "permission[]":"required",
        },
        errorPlacement: function (label, element) {
            if(element.attr("type") == "radio" )
            {
              label.insertAfter(element.closest(".form-check")); 
            }
            else if(element.attr("type") == "checkbox"){
            label.insertAfter(element.closest(".check")); 
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
            title: "please enter title",
            "permission[]": "Please select permission for role!",
        },
    });

    /* adding and updating role data */    
    $(".submit_value").on("click", function(event){
        event.preventDefault();
        var form = $('#role_form')[0];
        var formData = new FormData(form);
        if($("#role_form").valid()){   
            $.ajax({
                url: aurl + "/admin/role/store",
                type: 'POST',
                dataType: "JSON",
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
                success: function(data) {
                    $('#role_modal').modal('hide');
                    toaster_message(data.message,data.icon,data.redirect_url);
                },
            });
        } else {
            console.log('Please enter required fields!')
        }
    });

    /* deleteing role */
    $('body').on("click", ".role_delete", function(event){
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
                    dataType: "JSON",
                    url: aurl + "/admin/role/delete",
                    data: {id: id},
                    success: function(data) {
                        toaster_message(data.message,data.icon,data.redirect_url);
                    },
                    error: function (error) {
                        toaster_message(error,'error',''); 
                    }
                });
            }else if(result.dismiss === Swal.DismissReason.cancel){
                toaster_message('Cancle deleting','error','');
            }
        })
    });

    /* select all permissions */
    if ($('.permission:checked').length == $('.permission').length){
        $('#selectall').prop('checked',true);
    }

    $("#selectall").change(function(){  //"select all" change 
        var status = this.checked; // "select all" checked status
        $('.permission').each(function(){ //iterate all listed checkbox items
            this.checked = status; //change ".checkbox" checked status
        });
    });
    $('.permission').change(function(){ //".permission" change 
        //uncheck "select all", if one of the listed permission item is unchecked
        if(this.checked == false){ //if this item is unchecked
            $("#selectall")[0].checked = false; //change "select all" checked status to false
        }
        
        //check "select all" if all permission items are checked
        if ($('.permission:checked').length == $('.permission').length ){ 
            $("#selectall")[0].checked = true; //change "select all" checked status to true
        }
    });
});