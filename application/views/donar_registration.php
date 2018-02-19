<?php
$page_title = 'Donar Registration';
$table_name = 'Donar Details';
$action_page = 'PROCESS/user_reg_process.php';

$name = $form_data['name'];
$dob = $form_data['dob'];
$email =$form_data['email'];
$mobile =$form_data['mobile'];
$gender_male_check =($form_data['gender_male_check'] == 'Male')?'selected':'';
$gender_female_check =($form_data['gender_female_check'] == 'Female')?'selected':'';
$status = '1';
$status_check = ($form_data['status'] == '1')?'checked':'';;
$id = $form_data['id'];
?>
<!-- End Navbar -->
<div class="content">
    <div class="container-fluid">
                    <?php if (!empty($_SESSION['MSG'])) { ?>
                <div class="container">

                    <div class="alert alert-warning   alert-dismissable">
                        <strong>INFO</strong> 
                        <?php
                        echo $_SESSION['MSG'] . '.';
                        unset($_SESSION['MSG']);
                        ?> 
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

                        <form id="user_registration" method="post" action="<?php echo $action_page; ?>">
                            <input type="hidden" class="form-control"  name="id" value="<?php echo $id; ?>">
                            <input type="hidden" class="form-control"  name="method" value="<?php echo $form_action; ?>">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Name <span class="mandatory">*</span></label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Your name" value="<?php echo $name; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Email <span class="mandatory">*</span></label>
                                        <input type="text" class="form-control" id="email" name="email" placeholder="Enter Your Valid Email" value="<?php echo $email; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Mobile <span class="mandatory">*</span></label>
                                        <input type="text" class="form-control" id="mobile" name="mobile" maxlength="10" placeholder="Enter Your Mobile Number" value="<?php echo $mobile; ?>">
                                    </div>
                                </div>
                                    </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Gender <span class="mandatory">*</span></label>
                                        <div class="options">
                                            <label>Male</label><input type="radio"  id="gender-m" name="gender"  value="Male" <?php echo $gender_male_check; ?>>
                                            <label>Female</label><input type="radio"  id="gender" name="gender"  value="Female" <?php echo $gender_female_check; ?>>
                                        </div>
                                    </div>
                                </div>
                                <?php if(!empty($_SESSION['privilage'])){ ?>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Login Status</label>
                                        <div class="options">
                                            <label>Set To Active</label><input type="checkbox"  id="status" name="status"   value="1" <?php echo $status_check; ?> >
                                        </div>
                                    </div>
                                </div>
                                <?php }else{ ?>
                                <input type="hidden"  id="status" name="status"   value="<?php echo $status; ?>"  >
                                <?php } ?>
                            </div>
                            <button type="submit" class="btn btn-info btn-fill pull-right">Submit</button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--Table-->
        <?php if(!empty($_SESSION['privilage'])){ ?>
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
                                            $result = $query->select('user','*',['role' =>'user']);
                                            if(!empty($result)){
                                            while ($row=  mysqli_fetch_assoc($result)){ 
                                                ?>
                                            <tr>
                                                <td><?php echo $slno++; ?></td>
                                                <td><?php echo $row['name']; ?></td>
                                                <td><?php echo $row['mobile']; ?></td>
                                                <td><?php echo $row['email']; ?></td>
                                                <td><?php echo $row['gender']; ?></td>
                                                <td><?php echo $row['status']; ?></td>
                                                <td><a href="?action=edit&id=<?php echo $row['id'];?>"><button type="button" class="btn">Edit</button></a></td>
                                                <td>
                                                    <form method="post" action="<?php echo $action_page; ?>">
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
                <?php } ?>
    </div>