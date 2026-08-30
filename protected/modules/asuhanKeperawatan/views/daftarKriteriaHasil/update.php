<?php
$this->breadcrumbs = array(
    'Daftar Hasil Kriteria' => array('admin'),
    $model->kriteriahasil_daftar_id => array('view', 'id' => $model->kriteriahasil_daftar_id),
    'Ubah',
);

?>

<div class="panel panel-gradient">
    <div class="panel panel-heading">
        <div class="panel-title"> Ubah <b> Daftar Hasil Kriteria</b> </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial('_form', array('model' => $model)); ?>
    </div>
</div>