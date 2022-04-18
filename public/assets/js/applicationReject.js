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
          url: aurl + "/admin/application/rejected/listing", 
      },
      'columns': [
          { data: 'id' },
          { data: 'post' },
          { data: 'name' },
          { data: 'phone' },
          { data: 'email' },
          { data: 'cv' },
          { data: 'description' },
          { data: 'experience' },
          { data: 'reason' },
            
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

    
   
});