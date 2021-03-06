jQuery(document).ready(function ($) {
    request_id = $("#request_id").val();
    if(request_id != "" ){
                  request_id =request_id.split("-");
            organ_id =request_id[1];
            request_id =request_id[0];
            var data = {request_id: request_id,organ_id:organ_id};
            getrequest(base_url, data, 'hospital/ajax_request');  
    }
    $("#patient_search_id").click(function () {
         $('#requesteddonararea').hide();
         $('#restdonararea').hide();
        request_id =  $('#request_id').val();
         $('#form-restdonar').empty();
         $('#form-requesteddonar').empty();
        if (request_id != '') {
            request_id =request_id.split("-");
            organ_id =request_id[1];
            request_id =request_id[0];
            var data = {request_id: request_id,organ_id:organ_id};
            getrequest(base_url, data, 'hospital/ajax_request');

        }
    });
     $("#request_id").change(function () {
         $("#patient_request_id").val(this.value);
     });
        $('.datepick').datepicker({
            dateFormat: 'yy-mm-dd',
            minDate:0,
        });
});


function getrequest(base_url, data, url) {
    var html = "";
    var slno = 1;
    // Date Calcultation
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1; //January is 0!
    var yyyy = today.getFullYear();

    if (dd < 10) {
        dd = '0' + dd
    }

    if (mm < 10) {
        mm = '0' + mm
    }

    today = yyyy + '-' + mm + '-' + dd;
    // Date Calcultation End
    jQuery.ajax({
        url: base_url + '/' + url,
        dataType: 'json',
        type: 'post',
        data: data,
        success: function (response) {
            if(! isEmpty(response.notadded)) {
                html += '<table class="table table-hover table-striped">';
                html += '<thead>';
                html += '<th>Sl No.</th>';
                html += '<th>Donar Name</th>';
                html += '<th>Gender</th>';
                html += '<th>Mobile</th>';
                html += '<th>Location</th>';
                html += '<th>Blood Group</th>';
                html += '<th>Check to Request</th>';
                html += '<th>Hospital test date</th>';
                html += '</thead>';
                html += '<tbody>';
                $.each(response.notadded, function (key, value) {
                    html += '<tr>';
                    html += '<td>' + slno + '</td>';
                    html += '<td>' + value['name'] + '</td>';
                    html += '<td>' + value['mobile'] + '</td>';
                    html += '<td>' + value['gender'] + '</td>';
                    html += '<td>' + value['location'] + '</td>';
                    html += '<td>' + value['blood_group'] + '</td>';
                    html += '<td><input type="checkbox" value="1" name ="donar_request['+value['user_id']+']" /></td>';
                    html += '<td><input type="text" class="form-control datepick" name ="requested_date['+value['user_id']+']" value="'+today+'" /></td>';
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
            $('#form-restdonar').html(html);
            $('#restdonararea').show();
    html = "";        
if(! isEmpty(response.added)) {
                html += '<table class="table table-hover table-striped">';
                html += '<thead>';
                html += '<th>Sl No.</th>';
                html += '<th>Donar Name</th>';
                html += '<th>Gender</th>';
                html += '<th>Mobile</th>';
                html += '<th>Location</th>';
                html += '<th>Blood Group</th>';
                html += '<th>Status</th>';
                html += '</thead>';
                html += '<tbody>';
                $.each(response.added, function (key, value) {
                    html += '<tr>';
                    html += '<td>' + slno + '</td>';
                    html += '<td>' + value['name'] + '</td>';
                    html += '<td>' + value['gender'] + '</td>';
                    html += '<td>' + value['mobile'] + '</td>';
                    html += '<td>' + value['location'] + '</td>';
                    html += '<td>' + value['blood_group'] + '</td>';
                   
                    html += '<td><select class="form-control" name="status['+value['requesteddonar_id']+']">'; 
                     status = (value['status']=='0')? 'Selected':'';
                    html +=  '<option value ="0"  '+status+'> Requested</option>';
                     status = (value['status']=='1')? 'Selected':'';
                    html +=  '<option value ="1"  '+status+'>Organ Matching</option>';
                     status = (value['status']=='2')? 'Selected':'';
                    html +=  '<option value ="2"  '+status+'>Rejected</option>';
                    html +=  '</select></td>';
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
            
            
            $('#form-requesteddonar').html(html);
            $('#requesteddonararea').show();
        },
    });
}