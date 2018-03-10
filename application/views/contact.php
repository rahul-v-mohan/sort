<div class="content">
    <div class="container-fluid">
        <div class="row">
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
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Contact Us</h4>
                    </div>
                    <div class="card-body">
                        <form id="contact_form" method="post" action="<?php echo base_url('home/contact_process'); ?>">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Name <span class="mandatory">*</span></label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Your Name" value="<?php echo set_value('name'); ?>">
                                        <?php echo form_error('name', '<label class ="error">', '</label>'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Email <span class="mandatory">*</span></label>
                                        <input type="text" class="form-control" id="email" name="email" placeholder="Enter Your Email" value="<?php echo set_value('email'); ?>">
                                        <?php echo form_error('email', '<label class ="error">', '</label>'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Mobile <span class="mandatory">*</span></label>
                                        <input type="text" class="form-control" id="mobile" name="mobile" maxlength="10" placeholder="Enter Your Mobile" value="<?php echo set_value('mobile'); ?>">
                                    <?php echo form_error('mobile', '<label class ="error">', '</label>'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Message <span class="mandatory">*</span></label>
                                        <textarea  class="form-control" id="message" name="message"  placeholder="Enter Your message" rows="6" ><?php echo set_value('message'); ?></textarea>
                                         <?php echo form_error('message', '<label class ="error">', '</label>'); ?>
                                    </div>
                                </div>

                            </div>
                            <button type="submit" class="btn btn-info btn-fill pull-right">Submit</button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Address</h4>
                    </div>
                    <div class="card-body">
                        Address<br>
                        Address<br>
                        Address<br>
                        Address<br>
                    </div>
                </div>

            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Mobile</h4>
                    </div>
                    <div class="card-body">
                        Number<br>
                        Mail<br>
                    </div>
                </div>

            </div>
        </div>
    </div>