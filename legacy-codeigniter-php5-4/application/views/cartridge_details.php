<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Системa учёта картриджей</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel='stylesheet' href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" type='text/css' media='all' />
    <link rel='stylesheet' href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css" type='text/css' media='all' />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/datatables/datatables.css">
    <script type="text/javascript" charset="<?php echo base_url(); ?>assets/js/datatables/datatables.js"></script>
    <script src="<?php echo base_url();?>assets/js/datatables/datatables.js"></script>
</head>
<body>
<div class="modal-title">
    <h1 class="text-center">Системa учёта картриджей</h1>
</div>
<table class="table table-hover table-bordered table-striped table-condensed" id="itemlist">
    <?php
    if(!empty($cartridges))
    {
    ?>
    <thead>
    <tr class="table-info">
        <th>id</th>
        <th>Отдел-владелец</th>
        <th>Бренд</th>
        <th>Марка</th>
        <th>Код</th>
        <th>Кто заправил</th>
        <th>Состояние</th>
        <th>Примечание</th>
        <th>Вес до</th>
        <th>Вес после</th>
        <th>Разница в весе</th>
        <th>Дата ухода</th>
        <th>Дата прихода</th>
        <th class="no-sort">Изменить</th>
        <th class="no-sort">Удалить</th>
        <th class="no-sort">История</th>
        <th>ВС</th>
    </tr>
    <tfoot>
    <tr class="table-info">
        <th>id</th>
        <th>Отдел-владелец</th>
        <th>Бренд</th>
        <th>Марка</th>
        <th>Код</th>
        <th>Кто заправил</th>
        <th>Состояние</th>
        <th>Примечание</th>
        <th>Вес до</th>
        <th>Вес после</th>
        <th>Разница в весе</th>
        <th>Дата ухода</th>
        <th>Дата прихода</th>
        <th class="no-sort">Изменить</th>
        <th class="no-sort">Удалить</th>
        <th class="no-sort">История</th>
        <th>ВС</th>
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
            <td><?php if ($cartridge['technical_life'] == 1){echo "Рабочий";} else {echo "Выведен из работы";} ?></td>
            <td><?php echo $cartridge['comments'] ?></td>
            <td><?php echo $cartridge['weight_before'] ?></td>
            <td><?php echo $cartridge['weight_after'] ?></td>
            <td><?php echo $cartridge['weight_after'] -$cartridge['weight_before'] ?></td>
            <td><?php echo $cartridge['date_outcome'] ?></td>
            <td><?php echo $cartridge['date_income'] ?></td>
            <td>
                <a href="<?php echo base_url(); ?>cartridge/updatedetails/<?php echo $cartridge["id"]?>">
                    <button type="button" class="btn btn-success">Редактировать</button>
                </a>
            </td>
            <td>
                <button type="button" class="btn btn-danger"><?php
                    echo anchor('cartridge/deletedetails/'.$id, 'Удалить', array('onClick' => "return confirm('Удалить?')"));
                    ?></button>
            </td>
            <td>
                <a href="<?php echo base_url(); ?>cartridge/story/<?php echo $cartridge["id"]?>">
                    <button type="button" class="btn btn-outline-info">История</button>
                </a>
            </td>
            <td name="inservice"><?php echo $cartridge['inservice'] ?></td>
        </tr>
        <?php                   $i++;                        }                    ?>
    </tbody>
</table>
<?php
}    else     {        ?>
    <p class="alert alert-danger text-center">В базе данных нет записей</p>
<?php                    }                    ?>
</div>
</div>
</div>
<div class="add-cartridge text-center">
    <a href="<?php echo base_url(); ?>cartridge/addcartridgedata"><button class="btn btn-primary">Добавить картридж</button></a>
</div>
</div>
</div>
<script type="text/javascript" language="javascript">
    var inservice = document.getElementsByName("inservice"),
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
                "url": "https://cdn.datatables.net/plug-ins/1.10.16/i18n/Russian.json"
            }
        });
</script>
</body>
</html>