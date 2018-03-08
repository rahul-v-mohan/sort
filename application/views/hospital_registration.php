<?php
$page_title = 'Hospital Registration';
$table_name = 'Hospital Details';
$action_page = 'admin/hospital_reg_save';
$page_url ='admin/hospital_registration';
?>
<!-- End Navbar -->
<div class="content">
    <div class="container-fluid">
            <?php 
                  $msg=$this->session->flashdata('msg');
                  if($msg){
                ?>
                <div class="container">

                    <div class="alert alert-warning   alert-dismissable">
                        <strong>INFO</strong> 
                        <?php echo $msg;  ?> 
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
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Hospital Name <span class="mandatory">*</span></label>
                                        <input type="text" class="form-control" id="hospital_name" name="hospital_name" placeholder="Hospital Name" value="<?php echo set_value('hospital_name', $form_data['hospital_name']); ?>">
                                    <?php echo form_error('hospital_name', '<label class ="error">', '</label>'); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Mobile <span class="mandatory">*</span></label>
                                        <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Hospital Number" maxlength="10" value="<?php echo set_value('mobile', $form_data['mobile']); ?>">
                                    <?php echo form_error('mobile', '<label class ="error">', '</label>'); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Website Url </label>
                                        <input type="text" class="form-control" id="website_url" name="website_url" placeholder="Website URL" value="<?php echo set_value('website_url', $form_data['website_url']); ?>">
                                    <?php echo form_error('website_url', '<label class ="error">', '</label>'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Location <span class="mandatory">*</span></label>
                                        <input type="text" class="form-control" id="location" name="location" placeholder="Location" value="<?php echo set_value('location', $form_data['location']); ?>">
                                    <?php echo form_error('location', '<label class ="error">', '</label>'); ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>District <span class="mandatory">*</span></label>
                                        <input type="text" class="form-control" id="district" name="district" placeholder="District" value="<?php echo set_value('district', $form_data['district']); ?>">
                                    <?php echo form_error('district', '<label class ="error">', '</label>'); ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>State <span class="mandatory">*</span></label>
                                        <input type="text" class="form-control" id="state" name="state" placeholder="State" value="<?php echo set_value('state', $form_data['state']); ?>">
                                    <?php echo form_error('state', '<label class ="error">', '</label>'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Username </label>
                                        <input type="text" class="form-control" id="email" name="email" placeholder="Enter Your Valid Email" value="<?php echo set_value('email', $form_data['email']); ?>">
                                    <?php echo form_error('email', '<label class ="error">', '</label>'); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email <span class="mandatory">*</span></label>
                                        <input type="text" class="form-control" id="email_hospital" name="email_hospital" placeholder="Enter Hospital Email" value="<?php echo set_value('email_hospital', $form_data['email_hospital']); ?>">
                                    <?php echo form_error('email_hospital', '<label class ="error">', '</label>'); ?>
                                    </div>
                                </div>
                                    </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Login Status</label>
                                        <div class="options">
                                            <label>Set To Active</label><input type="checkbox"  id="status" name="status"   value="1"  <?php echo set_checkbox('status', '1',($form_data['status'] =='1')?TRUE:FALSE); ?> >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
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
                                    <h4 class="card-title"><?php echo $table_name;?></h4>
<!--                                    <p class="card-category">Manage users here</p>-->
                                </div>
                                <div class="card-body table-full-width table-responsive">
                                    <table class="table table-hover table-striped">
                                        <thead>
                                            <th>Sl No.</th>
                                            <th>Hospital Name</th>
                                            <th>Mobile</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            //get user details
                                            $slno = 1;
                                            if(!empty($hospital_datas)){
                                            foreach ($hospital_datas as $row){ 
                                                ?>
                                            <tr>
                                                <td><?php echo $slno++; ?></td>
                                                <td><?php echo $row['hospital_name']; ?></td>
                                                <td><?php echo $row['mobile']; ?></td>
                                                <td><?php echo $row['email']; ?></td>
                                                <td><?php echo $row['email_hospital']; ?></td>
                                                <td><?php echo $row['status']; ?></td>
                                                <td><a href="<?php echo base_url($page_url.'/'.$row['id']);?>"><button type="button" class="btn">Edit</button></a></td>
                                                <td>
                                                    <form method="post" action="<?php echo base_url('admin/hospital_delete');?>">
                                                        <input type="hidden"  id="id" name="id"   value="<?php echo $row['id']; ?>"  >
                                                        <input type="hidden"  id="method" name="method"   value="delete"  >
                                                        <button type="submit" class="btn">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            <?php }}else{ ?>
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