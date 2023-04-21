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
        type: 'POST',
        url: aurl + "/admin/review-list/listing",
    },
    'columns': [
        { data: 'id' },
        { data: 'name' },
        { data: 'post' },
        { data: 'action' },
    ]
});
$('#dataTableExample').each(function () {
    var datatable = $(this);
    // SEARCH - Add the placeholder for Search and Turn this into in-line form control
    var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
    search_input.attr('placeholder', 'Search');
    search_input.removeClass('form-control-sm');
    // LENGTH - Inline-Form control
    var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
    length_sel.removeClass('form-control-sm');
});

$(document).on('click', '.show-given-review', function () {
    $("#given_review").modal("show");

    var i_id = $(this).data('i_id');

    var reviews = $('#given_review_' + i_id).text();
    var data = JSON.parse(reviews);
    var html = '';
    html += '<div class="row mt-2 given-rating">';
    $.each(data, function (key, value) {
        if (value.type == 1) {
            html += '<div class="col-md-4">';
            html += '<div class="rating-details">';
            html += '<h5>HR Review</h5><hr>';
            for (i = 1; i <= value.rating; i++) {
                html += '<span class="fa fa-star given-rating-start"></span>';
                // html += '<input type="radio" id="star_' + i + '" class="rating-checked" value="' + i + '" checked/><label for="star_' + i + '" title="text"></label>';
            };
            html += '<p>' + value.description + '</p>';
            html += '</div>';
            html += '</div>';
        }
        if (value.type == 2) {
            html += '<div class="col-md-4">';
            html += '<div class="rating-details">';
            html += '<h5>Verble Review</h5><hr>';
            for (i = 1; i <= value.rating; i++) {
                html += '<span class="fa fa-star given-rating-start"></span>';
            };
            html += '<p>' + value.description + '</p>';
            html += '</div>';
            html += '</div>';
        }
        if (value.type == 3) {
            html += '<div class="col-md-4">';
            html += '<div class="rating-details">';

            html += '<h5>Technical Review</h5><hr>';
            for (i = 1; i <= value.rating; i++) {
                html += '<span class="fa fa-star given-rating-start"></span>';
            };
            html += '<p>' + value.description + '</p>';
            html += '</div>';
            html += '</div>';
        }
    });
    html += '</div>';
    $('#given_review_list').html(html);
});