<?php
$this->breadcrumbs = array(
    'Penyulit Hd Ms' => array('index'),
    'Create',
);

$this->menu = array(
    array('label' => 'List PenyulitHdM', 'url' => array('index')),
    array('label' => 'Manage PenyulitHdM', 'url' => array('admin')),
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Tambah <b>Penyulit HD</b></div>
    </div>
    <div class="panel-body">

        <?php echo $this->renderPartial('_form', array('model' => $model)); ?>
    </div>
</div>