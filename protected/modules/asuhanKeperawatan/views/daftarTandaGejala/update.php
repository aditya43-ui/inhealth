<?php
$this->breadcrumbs = array(
    'Daftar Tanda Gejala' => array('admin'),
    $model->tandagejala_daftar_id => array('view', 'id' => $model->tandagejala_daftar_id),
    'Ubah',
);

?>

<div class="panel panel-gradient">
    <div class="panel panel-heading">
        <div class="panel-title"> Ubah <b> Daftar Tanda Gejala</b> </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial('_form', array('model' => $model)); ?>
    </div>
</div>