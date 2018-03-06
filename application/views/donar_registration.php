<?php
$page_title = 'Donar Registration';
$table_name = 'Donar Details';
$page_url = 'home/donar_registration';

$bloodgrouplist = ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'];
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

                        <form id="donar_registration" method="post" action="<?php echo base_url($action_page); ?>">
                            <input type="hidden" class="form-control"  name="id" value="<?php echo $form_data['user_id']; ?>">
                            <input type="hidden" class="form-control"  name="method" value="<?php echo $form_method; ?>">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Name <span class="mandatory">*</span></label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Your name" value="<?php echo set_value('name', $form_data['name']); ?>">
                                        <?php echo form_error('name', '<label class ="error">', '</label>'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Email <span class="mandatory">*</span></label>
                                        <input type="text" class="form-control" id="email" name="email" placeholder="Enter Your Valid Email" value="<?php echo set_value('email', $form_data['email']); ?>">
                                        <?php echo form_error('email', '<label class ="error">', '</label>'); ?>
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
                                        <label>House Name <span class="mandatory">*</span></label>
                                        <input type="text" class="form-control" id="house_name" name="house_name" placeholder="House Name" value="<?php echo set_value('house_name', $form_data['house_name']); ?>">
                                        <?php echo form_error('house_name', '<label class ="error">', '</label>'); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Location <span class="mandatory">*</span></label>
                                        <input type="text" class="form-control" id="location" name="location" placeholder="Location" value="<?php echo set_value('location', $form_data['location']); ?>">
                                        <?php echo form_error('location', '<label class ="error">', '</label>'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>District <span class="mandatory">*</span></label>
                                        <input type="text" class="form-control" id="district" name="district" placeholder="District" value="<?php echo set_value('district', $form_data['district']); ?>">
                                        <?php echo form_error('district', '<label class ="error">', '</label>'); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>State <span class="mandatory">*</span></label>
                                        <input type="text" class="form-control" id="state" name="state" placeholder="State" value="<?php echo set_value('state', $form_data['state']); ?>">
                                        <?php echo form_error('state', '<label class ="error">', '</label>'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Height</label>
                                        <input type="text" class="form-control" id="height" name="height" placeholder="Height (Centimetres)" value="<?php echo set_value('height', $form_data['height']); ?>">
                                        <?php echo form_error('height', '<label class ="error">', '</label>'); ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Weight</label>
                                        <input type="text" class="form-control" id="weight" name="weight" placeholder="Weight (Kilograms)" value="<?php echo set_value('weight', $form_data['weight']); ?>">
                                        <?php echo form_error('weight', '<label class ="error">', '</label>'); ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Blood Group <span class="mandatory">*</span></label>
                                        <select id="blood_group" name="blood_group" class="form-control">
                                            <option value="">Select</option>
                                            <?php foreach ($bloodgrouplist as $temp) { ?>
                                                <option  <?php echo set_select('blood_group', $temp, ($form_data['blood_group'] == $temp) ? TRUE : FALSE); ?> value="<?php echo $temp; ?>"><?php echo $temp; ?></option>
                                            <?php } ?>
                                        </select>
                                        <?php echo form_error('blood_group', '<label class ="error">', '</label>'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
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
                                <div class="col-md-6">
                                    <?php if (!empty($record_view)) { ?> 
                                        <div class="form-group">
                                            <label>Login Status</label>
                                            <div class="options">
                                                <label>Set To Active</label><input type="checkbox"  id="status" name="status"   value="1"  <?php echo set_checkbox('status', '1', ($form_data['status'] == '1') ? TRUE : FALSE); ?> >
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <input type="hidden"   name="status"   value="<?php echo $form_data['status']; ?>" >        
                                    <?php } ?>
                                </div>
                            </div>
                            <?php if (!empty($organs)) { ?>
                <div class="card-body table-full-width table-responsive">
                    <table class="table table-hover table-striped">
                                        <tr><th>Organ</th><th>Willing To Donate</th><th>Organ Ready</th></tr>
                                    <?php foreach ($organs as $organ) { ?>
                                        <tr>
                                            
                                            <td><label><?php echo $organ['organ']; ?></label></td>
                                            <td> <input type="checkbox"  id="organ-<?php echo $organ['id']; ?>" name="organ[<?php echo $organ['id']; ?>]"   value="1" ></td>
                                            <td> <input type="checkbox"  id="organ-avail-<?php echo $organ['id']; ?>" name="organ_avail[<?php echo $organ['id']; ?>]"   value="1"  ></td>
                                    </tr>
                        <?php } ?>
                  </table>
                </div>
                <?php } ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>General Health Remark</label>
                            <textarea type="checkbox" class="form-control" id="health_remark" name="health_remark" ><?php echo set_value('health_remark', $form_data['health_remark']); ?></textarea>
                            <?php echo form_error('health_remark', '<label class ="error">', '</label>'); ?>
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
<?php if (!empty($record_view)) { ?> 
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
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Gender</th>
                        <th>Status</th>
                        <th>Edit</th>
                        <th>Delete</th>
                        </thead>
                        <tbody>
                            <?php
                            //get user details
                            $slno = 1;
                            if (!empty($donar_datas)) {
                                foreach ($donar_datas as $row) {
                                    ?>
                                    <tr>
                                        <td><?php echo $slno++; ?></td>
                                        <td><?php echo $row['name']; ?></td>
                                        <td><?php echo $row['mobile']; ?></td>
                                        <td><?php echo $row['email']; ?></td>
                                        <td><?php echo $row['gender']; ?></td>
                                        <td><?php echo $row['status']; ?></td>
                                        <td><a href="<?php echo base_url($page_url . '/' . $row['id']); ?>"><button type="button" class="btn">Edit</button></a></td>
                                        <td>
                                            <form method="post" action="<?php echo base_url('home/donar_delete'); ?>">
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
<?php } ?>
</div>