<?php
$page_title = 'Request Interface';
$action_page_add = 'hospital/request_process_add';
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
                                        <select id="request_id" name="" class="form-control">
                                            <option value="">Select</option>
                                            <?php foreach ($patients as  $temp) { ?>
                                                <option  <?php echo set_select('patient_id', $temp['id'],($form_data['id']==$temp['id'])?TRUE:FALSE); ?> value="<?php echo $temp['id'].'-'.$temp['organ_id']; ?>"><?php echo $temp['patient_name'].' - '.$temp['organ']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <button type="button" id="patient_search_id" class="btn btn-default btn-fill pull-right">Search</button>
                                </div>
                            </div>

                        <div id="restdonararea" style=" display: none">
                            <label><h3>Not Requested Donor</h3></label>
                            <form id="hospital_registration" method="post" action="<?php echo base_url($action_page_add); ?>">
                                <input type="hidden" class="form-control"  name="patient_request_id"  id="patient_request_id" value="<?php echo $temp['id'].'-'.$temp['organ_id']; ?>">
                                <div id="form-restdonar">
                                </div>
                                <button type="submit" class="btn btn-info btn-fill pull-right">Submit</button>
                                <div class="clearfix"></div>
                            </form>
                        </div>
                        <div id="requesteddonararea" style=" display: none">
                            <label><h3> Requested Donor</h3></label>
                                <div id="form-requesteddonar">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Table-->
    </div>
    <script>var recipient = "<?php echo $form_data['id']; ?>"; </script>