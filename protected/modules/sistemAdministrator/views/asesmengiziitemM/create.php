<?php
$this->breadcrumbs = array(
    'Item Asesmen Gizi' => array('admin'),
    'Tambah',
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-plus-square"></i> Tambah <b>Item Asesmen Gizi</b>
        </div>
    </div>
    <div class="panel-body">
        <?php echo $this->renderPartial('_form', array('model' => $model)); ?>
    </div>
</div>