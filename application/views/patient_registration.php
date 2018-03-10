<?php
$page_title = 'Patient Registration';
$table_name = 'Patient Details';
$action_page = 'hospital/patient_reg_save';
$page_url = 'hospital/patient_registration';
?>

<!-- End Navbar -->
<div class="content">
    <div class="container-fluid">
        <?php
        $msg = $this->session->flashdata('msg');
        if ($msg) {
            ?>
            <div class="container">

                <div class="alert alert-warning   alert-dismissable">
                    <strong>INFO</strong> 
                    <?php echo $msg; ?> 
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                </div>
            </div>
        <?php } ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><?= $page_title ?></h4>
                    </div>
                    <div class="card-body">

                        <form id="hospital_registration" method="post" action="<?php echo base_url($action_page); ?>">
                            <input type="hidden" class="form-control"  name="id" value="<?php echo $form_data['id']; ?>">
                            <input type="hidden" class="form-control"  name="method" value="<?php echo $form_method; ?>">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Patient Name <span class="mandatory">*</span></label>
                                        <input type="text" class="form-control" id="patient_name" name="patient_name" placeholder="Patient Name" value="<?php echo set_value('patient_name', $form_data['patient_name']); ?>">
                                        <?php echo form_error('patient_name', '<label class ="error">', '</label>'); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Patient ID <span class="mandatory">*</span></label>
                                        <input type="text" class="form-control" id="patient_id" name="patient_id" placeholder="Patient ID" value="<?php echo set_value('patient_id', $form_data['patient_id']); ?>">
                                        <?php echo form_error('patient_id', '<label class ="error">', '</label>'); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Mobile <span class="mandatory">*</span></label>
                                        <input type="text" class="form-control" id="mobile" name="mobile" maxlength="10" placeholder="Enter Your Mobile Number" value="<?php echo set_value('mobile', $form_data['mobile']); ?>">
                                        <?php echo form_error('mobile', '<label class ="error">', '</label>'); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Date Of Birth <span class="mandatory">*</span></label>
                                        <input type="text" class="form-control" id="dob" name="dob"  placeholder="DOB" value="<?php echo set_value('dob', $form_data['dob']); ?>">
                                        <?php echo form_error('dob', '<label class ="error">', '</label>'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label> Hospital <span class="mandatory">*</span></label>
                                        <select id="hospital_id" name="hospital_id" class="form-control">
                                            <option value="">Select</option>
                                            <?php foreach ($hospital_datas as $hid => $temp) { ?>
                                                <option  <?php echo set_select('hospital_id', $hid, ($form_data['hospital_id'] == $hid) ? TRUE : FALSE); ?> value="<?php echo $hid; ?>"><?php echo $temp; ?></option>
                                            <?php } ?>
                                        </select>
                                        <?php echo form_error('hospital_id', '<label class ="error">', '</label>'); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Gender <span class="mandatory">*</span></label>
                                        <div class="options">
                                            <label>Male</label><input type="radio"  id="gender-m" name="gender"  value="Male" <?php echo set_radio('gender', 'Male', ($form_data['gender'] == 'Male') ? TRUE : FALSE); ?>>
                                            <label>Female</label><input type="radio"  id="gender" name="gender"  value="Female" <?php echo set_radio('gender', 'Female', ($form_data['gender'] == 'Female') ? TRUE : FALSE); ?>>
                                            <?php echo form_error('gender', '<label class ="error">', '</label>'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if (!empty($organs)) { ?>
                                <div class="card-body table-full-width table-responsive">
                                    <table class="table table-hover table-striped">
                                        <tr><th>Organ</th><th>Organ Requested</th><th>Status</th></tr>
                                        <?php foreach ($organs as $organ) { ?>
                                            <tr>

                                                <td><label><?php echo $organ['organ']; ?></label></td>
                                                <td> <input type="checkbox"  id="organ-<?php echo $organ['id']; ?>" name="organ[<?php echo $organ['id']; ?>]"   value="1" <?php echo set_checkbox('organ[' . $organ['id'] . ']', '1', (in_array($organ['id'], $form_data['organs'])) ? TRUE : FALSE); ?> /> </td>
                                                <td> 
                                                    <select id="organ_status" name="organ_status[<?php echo $organ['id']; ?>]" class="form-control">
                                                        <option value="">Select</option>
                                                        <?php foreach ($organ_allstatus as $hid => $temp) { ?>
                                                            <option  <?php echo set_select('organ_status[' . $organ['id'] . ']', $hid, (!empty($form_data['organ_status'][$organ['id']]) && $form_data['organ_status'][$organ['id']] == $hid) ? TRUE : FALSE); ?> value="<?php echo $hid; ?>"><?php echo $temp; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>


                                            </tr>
                                        <?php } ?>
                                    </table>
                                </div>
                            <?php } ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Patient Health Condition <span class="mandatory">*</span></label>
                                        <input type="text" class="form-control" id="health_conditon" name="health_conditon" placeholder="Patient Health Condition" value="<?php echo set_value('health_conditon', $form_data['health_conditon']); ?>">
                                        <?php echo form_error('health_conditon', '<label class ="error">', '</label>'); ?>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-info btn-fill pull-right">Submit</button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--Table-->
        <div class="row">
            <div class="col-md-12">
                <div class="card strpied-tabled-with-hover">
                    <div class="card-header ">
                        <h4 class="card-title"><?php echo $table_name; ?></h4>
<!--                                    <p class="card-category">Manage users here</p>-->
                    </div>
                    <div class="card-body table-full-width table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                            <th>Sl No.</th>
                            <th>Patient Name</th>
                            <th>Patient ID</th>
                            <th>Hospital</th>
                            <th>Edit</th>
                            <th>Delete</th>
                            </thead>
                            <tbody>
                                <?php
                                //get user details
                                $slno = 1;
                                if (!empty($patient_datas)) {
                                    foreach ($patient_datas as $row) {
                                        ?>
                                        <tr>
                                            <td><?php echo $slno++; ?></td>
                                            <td><?php echo $row['patient_name']; ?></td>
                                            <td><?php echo $row['patient_id']; ?></td>
                                            <td><?php echo $row['hospital_name']; ?></td>
                                            <td><a href="<?php echo base_url($page_url . '/' . $row['id']); ?>"><button type="button" class="btn">Edit</button></a></td>
                                            <td>
                                                <form method="post" action="<?php echo base_url('admin/hospital_delete'); ?>">
                                                    <input type="hidden"  id="id" name="id"   value="<?php echo $row['id']; ?>"  >
                                                    <input type="hidden"  id="method" name="method"   value="delete"  >
                                                    <button type="submit" class="btn">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php }
                                } else { ?>
                                    <tr>
                                        <td colspan="6">No Records Found</td>
                                    </tr>
<?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>