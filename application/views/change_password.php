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
                        <h4 class="card-title">Change Password</h4>
                    </div>
                    <div class="card-body">

                        <form id="change_password_form" method="post" action="<?php echo base_url($action_url); ?>">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Current Password <span class="mandatory">*</span></label>
                                        <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Enter Your Current Password" >
                                        <?php echo form_error('current_password', '<label class ="error">', '</label>'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>New Password <span class="mandatory">*</span></label>
                                        <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Enter Your New Password" >
                                        <?php echo form_error('new_password', '<label class ="error">', '</label>'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Confirm Password <span class="mandatory">*</span></label>
                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="ReEnter Your New Password" >
                                        <?php echo form_error('confirm_password', '<label class ="error">', '</label>'); ?>
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
   
    </div>