<?php
$page_title = 'Request View';
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

                        <table class="table table-hover table-striped">
                            <thead>
                            <th>Date</th>    
                            <th>Hospital Name</th>    
                            <th>Patient Name</th>    
                            <th>Organ</th>     
                            <th>Status</th>    
                            </thead>
                            <tbody>

                                <?php
                                foreach ($requests as $detail) {
                                    $arr = ["0" => 'Requested', "1" => 'Organ Matched', "2" => 'Rejected'];
                                    echo (array_key_exists($detail['status'], $arr)) ? $arr[$detail['status']] : "";
                                    ?>
                                    <tr>
                                        <td ><?php echo $detail['requested_date']; ?></td>
                                        <td><?php
                                            echo $detail['hospital_name'] . "</br>";
                                            echo $detail['district'] . " | " . $detail['state'] . "</br>";
                                            echo $detail['mobile'] . " | " . $detail['email_hospital'];
                                            ?></td>
                                        <td><?php echo $detail['patient_name'] . "</br>({$detail["patient_id"]})"; ?></td>
                                        <td><?php echo $detail['organ']; ?></td>
                                        <td><?php // echo  ?></td>
                                    </tr>
                                <?php } ?>

                            </tbody>
                        </table>  
                    </div>
                </div>
            </div>
        </div>
    </div>