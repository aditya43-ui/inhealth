<?php
$this->breadcrumbs = array(
    'Biaya Lembur' => array('admin'),
    'Create',
);

$this->menu = array(
    array('label' => 'List BiayalemburM', 'url' => array('index')),
    array('label' => 'Manage BiayalemburM', 'url' => array('admin')),
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-plus-square"></i> Tambah <b>Biaya Lembur</b>
        </div>
    </div>
    <div class="panel-body">
        <?php echo $this->renderPartial('_form', array('model' => $model)); ?>
    </div>
</div>