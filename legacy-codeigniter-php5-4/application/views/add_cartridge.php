<?php 
/**
 * Add Cartridge View
 * 
 * Form for adding new cartridge records to the system
 * 
 * @var CI_Controller $this CodeIgniter controller instance
 * @property CI_Session $session Session library for flash messages
 * @var string validation_errors() Form validation errors
 */
defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Cartridge - Cartridge Management System</title>
    <link rel='stylesheet' href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" type='text/css' media='all' />

</head>
<body>
<div class="col-lg-auto">
    <div class="container">
        <div class="form-container">
            <div class="form-title">
                <h1 class="text-center">Add New Cartridge</h1>
            </div>
            <?php echo $this->session->flashdata('msg'); ?>
            <?php echo validation_errors('<div class ="alert alert-danger">','</div>');?>
            <form action="<?php echo base_url(); ?>cartridge/addcartridgedata" method="post">
                <div class="form-group ">
                    <label class="control-label" for="owner">Owner Department</label>
                    <input type="text" class="form-control" id="owner" name="owner" placeholder="Department or location" required="">
                </div>
                <div class="form-group">
                    <label for="marks">Model/Code</label>
                    <input type="text" class="form-control" id="marks" name="marks" placeholder="Model e.g. CW-C725M" required="">
                </div>
                <div class="form-group">
                    <label class="form-control-label" for="brand">Brand</label>
                    <select class="form-control" id="brand" name="brand" placeholder="Manufacturer" required="">
                        <option value="ColorWay">ColorWay</option>
                        <option value="HP">HP</option>
                        <option value="Canon">Canon</option>
                        <option value="No Brand">No Brand</option>
                        <option value="Samsung">Samsung</option>
                        <option value="Unknown">Unknown</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-control-lg" for="code">Code</label>
                    <input type="number" class="form-input" id="code" name="code" placeholder="4-digit code from label">
                </div>
                <div class="form-group">
                    <label class="control-label" for="servicename">Service Provider</label>
                    <select autofocus class="form-control" id="servicename" name="servicename" placeholder="Which service center performed the work" required="">
                        <option value="Elite-Service">Elite-Service</option>
                        <option value="Unknown">Unknown</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="technical_life">Technical Status</label>
                    <select class="form-control" id="technical_life" name="technical_life" placeholder="Working/Not working" required="">
                    <option value="1">Working</option>
                    <option value="0">Out of Service</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="weight_before">Weight Before</label>
                    <input type="number" class="form-control" id="weight_before" name="weight_before" placeholder="Weight before refill" required="">
                </div>
                <div class="form-group">
                    <label class="control-label" for="weight_after">Weight After</label>
                    <input type="number" class="form-control" id="weight_after" name="weight_after" placeholder="Weight after refill" required="">
                </div>
                <div class="form-group">
                    <label class="control-label" for="comments">Comments</label>
                    <input type="text" class="form-control" id="comments" name="comments" placeholder="Additional comments">
                </div>
                <div class="form-group">
                    <input type="submit" class="form-control btn btn-primary" id="submit" value="Save to Database">
                </div>
            </form>
            <div class="add-cartridge text-center">
                <a href="<?php echo base_url(); ?>cartridge/"><button class="btn btn-success">Back to Main</button></a>
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