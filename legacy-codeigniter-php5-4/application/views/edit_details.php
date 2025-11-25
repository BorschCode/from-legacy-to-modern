<?php
/**
 * Edit Cartridge Details View
 * 
 * Form for editing existing cartridge records
 * 
 * @var array $data Array containing cartridge data to edit
 * @property CI_Controller $this CodeIgniter controller instance
 * @property CI_Session $session Session library for flash messages
 */
defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Cartridge</title>
    <link rel='stylesheet' href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" type='text/css' media='all' />

</head>
<body>
<div class="col-lg-auto">
    <div class="container">
        <div class="form-container">
            <div class="form-title">
                <h1 class="text-center">Edit Cartridge</h1>
            </div>
            <?php echo $this->session->flashdata('msg'); ?>
            <?php foreach ($data as $key => $value) {
                ?>
                <form action="<?php echo base_url();?>cartridge/updatedetails/<?php echo $value['id']; ?>" method="post">
                    <div class="form-group">
                        <label class="control-label" for="owner">Owner Department</label>
                        <input type="text" class="form-control" id="owner" name="owner" value="<?php echo $value['owner']; ?>" required="">
                    </div>
                    <!--<div class="form-group">
                        <label class="control-label" for="marks">Марка/шифр</label>
                        <input type="text" class="form-control" id="marks" name="marks" value="<?php echo $value['marks']; ?>" required="">
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="brand">Бренд</label>
                        <input type="text" class="form-control" id="brand" name="brand" value="<?php echo $value['brand']; ?>" required="">
                    </div> -->
                    <div class="form-group">
                        <label class="control-label" for="code">Code</label>
                        <input type="text" class="form-control" id="code" name="code" value="<?php echo $value['code']; ?>" required="">
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="servicename">Service Provider</label>
                        <input type="text" class="form-control" id="servicename" name="servicename" value="<?php echo $value['servicename']; ?>" required="">
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="technical_life">Technical Status</label>
                        <select class="form-control" id="technical_life" name="technical_life" placeholder="Working/Not working" value="<?php echo $value['technical_life']; ?>" required="">
                            <option value="1">Working</option>
                            <option value="0">Out of Service</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="weight_before">Weight Before Refill</label>
                        <input type="number" class="form-control" id="weight_before" name="weight_before" value="<?php echo $value['weight_before']; ?>" required="">
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="weight_after">Weight After Refill</label>
                        <input type="number" class="form-control" id="weight_after" name="weight_after" value="<?php echo $value['weight_after']; ?>" required="">
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="date_outcome">Date Sent to Service</label>
                        <input type="date" class="form-control" id="date_outcome" name="date_outcome" value="<?php echo ($value['date_outcome'] != '0000-00-00') ? $value['date_outcome'] : ''; ?>" required="">
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="date_income">Date Received from Service</label>
                        <input type="date" class="form-control" id="date_income" name="date_income" value="<?php echo ($value['date_income'] != '0000-00-00') ? $value['date_income'] : ''; ?>" required="">
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="comments">Comments</label>
                        <input type="text" class="form-control" id="comments" name="comments" value="<?php echo $value['comments']; ?>">
                    </div>


                    <div class="form-group">
                        <input type="submit" class="form-control btn btn-primary" id="submit" value="Update Cartridge Data">
                    </div>

                </form>
                <?php            }            ?>
            <div class="add-cartridge text-center">
                <a href="<?php echo base_url(); ?>cartridge/"><button class="btn btn-success">Back</button></a>
            </div>
        </div>
    </div>
</div>
<!-- jQuery and Bootstrap with Popper.js -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>

</body>
</html>