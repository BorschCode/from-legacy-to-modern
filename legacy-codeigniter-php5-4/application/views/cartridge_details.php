<?php 
/**
 * Cartridge Details View
 * 
 * Displays a table of all cartridge records with CRUD operations
 * 
 * @var array $cartridges Array of cartridge records from database
 * @property CI_Controller $this CodeIgniter controller instance
 */
defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cartridge Management System</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel='stylesheet' href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" type='text/css' media='all' />
    <link rel='stylesheet' href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css" type='text/css' media='all' />
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
</head>
<body>
<div class="modal-title">
    <h1 class="text-center">Cartridge Management System</h1>
</div>
<table class="table table-hover table-bordered table-striped table-condensed" id="itemlist">
    <?php
    if(!empty($cartridges))
    {
    ?>
    <thead>
    <tr class="table-info">
        <th>id</th>
        <th>Owner Department</th>
        <th>Brand</th>
        <th>Model</th>
        <th>Code</th>
        <th>Service Provider</th>
        <th>Status</th>
        <th>Comments</th>
        <th>Weight Before</th>
        <th>Weight After</th>
        <th>Weight Difference</th>
        <th>Date Sent</th>
        <th>Date Received</th>
        <th class="no-sort">Edit</th>
        <th class="no-sort">Delete</th>
        <th class="no-sort">History</th>
        <th>In Service</th>
    </tr>
    <tfoot>
    <tr class="table-info">
        <th>id</th>
        <th>Owner Department</th>
        <th>Brand</th>
        <th>Model</th>
        <th>Code</th>
        <th>Service Provider</th>
        <th>Status</th>
        <th>Comments</th>
        <th>Weight Before</th>
        <th>Weight After</th>
        <th>Weight Difference</th>
        <th>Date Sent</th>
        <th>Date Received</th>
        <th class="no-sort">Edit</th>
        <th class="no-sort">Delete</th>
        <th class="no-sort">History</th>
        <th>In Service</th>
    </tr>
    </tfoot>
    <tbody>
    <?php
    $i = 1;
    foreach ($cartridges as $cartridge)
    {
        $id = $cartridge['id'];                                ?>
        <tr>
            <td><?php echo $cartridge['id'] ?></td>
            <td><?php echo $cartridge['owner'] ?></td>
            <td><?php echo $cartridge['brand'] ?></td>
            <td><?php echo $cartridge['marks'] ?></td>
            <td><?php echo $cartridge['code'] ?></td>
            <td><?php echo $cartridge['servicename'] ?></td>
            <td><?php if ($cartridge['technical_life'] == 1){echo "Working";} else {echo "Out of Service";} ?></td>
            <td><?php echo $cartridge['comments'] ?></td>
            <td><?php echo $cartridge['weight_before'] ?></td>
            <td><?php echo $cartridge['weight_after'] ?></td>
            <td><?php echo $cartridge['weight_after'] -$cartridge['weight_before'] ?></td>
            <td><?php echo $cartridge['date_outcome'] ?></td>
            <td><?php echo $cartridge['date_income'] ?></td>
            <td>
                <a href="<?php echo base_url(); ?>cartridge/updatedetails/<?php echo $cartridge["id"]?>">
                    <button type="button" class="btn btn-success">Edit</button>
                </a>
            </td>
            <td>
                <button type="button" class="btn btn-danger"><?php
                    echo anchor('cartridge/deletedetails/'.$id, 'Delete', array('onClick' => "return confirm('Delete?')"));
                    ?></button>
            </td>
            <td>
                <a href="<?php echo base_url(); ?>cartridge/story/<?php echo $cartridge["id"]?>">
                    <button type="button" class="btn btn-outline-info">History</button>
                </a>
            </td>
            <td data-name="inservice"><?php echo $cartridge['inservice'] ?></td>
        </tr>
        <?php                   $i++;                        }                    ?>
    </tbody>
</table>
<?php
}    else     {        ?>
    <p class="alert alert-danger text-center">No records found in database</p>
<?php                    }                    ?>
</div>
</div>
</div>
<div class="add-cartridge text-center">
    <a href="<?php echo base_url(); ?>cartridge/addcartridgedata"><button class="btn btn-primary">Add Cartridge</button></a>
</div>
</div>
</div>
<script type="text/javascript" language="javascript">
    var inservice = document.querySelectorAll('[data-name="inservice"]'),
        length = inservice.length;
    for(i=0; i<length;i++)
    {
        if (inservice[i].innerText == 1)
        {
            inservice[i].className = 'bg-danger';
            inservice[i].parentNode.className = 'bg-warning';
        }
    }
    $('#itemlist').DataTable(
        {
            paging: false,
            select: true,
            "order": [[16,"desc"],[11,"asc"],[12,"asc"]],
            columnDefs: [                { targets: 'no-sort', orderable: false }            ],
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.16/i18n/English.json"
            }
        });
</script>
</body>
</html>