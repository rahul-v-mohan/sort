<?php
$page_title = 'Request Interface';
$action_page = 'hospital/request_process';
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


                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label> Patient <span class="mandatory">*</span></label>
                                        <select id="request_id" name="request_id" class="form-control">
                                            <option value="">Select</option>
                                            <?php foreach ($patients as  $temp) { ?>
                                                <option  <?php echo set_select('patient_id', $temp['id'],($form_data['id']==$temp['id'])?TRUE:FALSE); ?> value="<?php echo $temp['id']; ?>"><?php echo $temp['patient_name'].' - '.$temp['organ']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <button type="button" id="patient_search_id" class="btn btn-default btn-fill pull-right">Search</button>
                                </div>
                            </div>
                        <div id="requesteddonararea" style=" display: none">
                            <form id="hospital_registration" method="post" action="<?php echo base_url($action_page); ?>">
                                <input type="hidden" class="form-control"  name="id" value="">
                                <input type="hidden" class="form-control"  name="method" value="update">
                                <button type="submit" class="btn btn-info btn-fill pull-right">Update</button>
                                <div class="clearfix"></div>
                            </form>
                        </div>
                        <div id="restdonararea" style=" display: none">
                            <form id="hospital_registration" method="post" action="<?php echo base_url($action_page); ?>">
                                <input type="hidden" class="form-control"  name="id" value="">
                                <input type="hidden" class="form-control"  name="method" value="insert">
                                <button type="submit" class="btn btn-info btn-fill pull-right">Submit</button>
                                <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Table-->
    </div>