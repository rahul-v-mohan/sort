
<!-- End Navbar -->
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
                        <h4 class="card-title">Login</h4>
                    </div>
                    <div class="card-body">
                        <form id="log_in_form" method="post" action="<?php echo base_url('home/logincheck'); ?>">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="text" class="form-control" id="email" name="email" placeholder="Enter Your Username" value="">
                                        <?php echo form_error('email', '<label class ="error">', '</label>'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" class="form-control" id="password" name="password"  placeholder="Enter Your Password" value="">
                                        <?php echo form_error('password', '<label class ="error">', '</label>'); ?>
                                    </div>
                                </div>

                            </div>
                            
                            <button type="submit" class="btn btn-info btn-fill pull-right">Login</button>
                            <a href="<?php echo base_url('home/forget_password'); ?>">Forget Password</a> 
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
