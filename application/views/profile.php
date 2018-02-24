<?php
$page_title = 'Profile';
?>

    
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
        <?php if(!empty($profile)){ ?> 
        <div class="row">
            <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <div class="card  table-plain-bg">
                                <div class="card-header ">
                                    <h4 class="card-title"><?php echo $page_title;?></h4>
<!--                                    <p class="card-category">Manage users here</p>-->
                                </div>
                                <div class="card-body ">
                                    <table class="table table-hover">
                                                                          <tbody>
                                            <tr><td>Name</td><td><?php echo $profile['name']; ?></td></tr>
                                            <tr><td>Gender</td><td><?php echo $profile['gender']; ?></td></tr>
                                            <tr><td>Date Of Birth</td><td><?php echo $profile['dob']; ?></td></tr>
                                            <tr><td>Mobile</td><td><?php echo $profile['mobile']; ?></td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                                   <div class="col-md-3"></div>
                    </div>
        <?php } ?>
        </div>
    </div>
    </div>