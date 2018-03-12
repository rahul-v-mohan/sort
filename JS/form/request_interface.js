jQuery(document).ready(function ($) {
    
    
    $("#patient_search_id").click(function () {
         $('#requesteddonararea').attr('display','none');
         $('#restdonararea').attr('display','none');
        request_id =  $('#request_id').val();
        if (request_id != '') {
            request_id =request_id.split("-");
            organ_id =request_id[1];
            request_id =request_id[0];
            var data = {request_id: request_id,organ_id:organ_id};
            getrequest(base_url, data, 'hospital/ajax_request');

        }
    });

});


function getrequest(base_url, data, url) {
    var html = "";
    var slno = 1;
    jQuery.ajax({
        url: base_url + '/' + url,
        dataType: 'json',
        type: 'post',
        data: data,
        success: function (response) {
            if (response.result == 1) {
                html += '<table class="table table-hover table-striped">';
                html += '<thead>';
                html += '<th>Sl No.</th>';
                html += '<th>Slot Name</th>';
                html += '<th>Booking</th>';
                html += '</thead>';
                html += '<tbody>';
                $.each(response.data, function (key, value) {
                    html += '<tr>';
                    html += '<td>' + slno + '</td>';
                    html += '<td>' + value['slot_name'] + '</td>';
                    html += '<td><button class="booking_button" id="' + value['id'] + '">Booking</button></td>';
                    html += '</tr>';
                    slno++;
                });

                html += '</tbody>';
                html += '</table>';
            } else {
                html += '<table class="table table-hover table-striped">';
                html += '<tr>';
                html += '<td colspan="4">No Records Found</td>';
                html += '</tr>';
                html += '</table>';
            }
            $('#slot-search-area').html(html);
        },
    });
}