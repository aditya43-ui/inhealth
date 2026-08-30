<?php
$this->breadcrumbs = array(
    'Konfigurasi Tarif Rumah Sakit' => array('admin'),
    $model->konfigtarifambulans_id => array('view', 'id' => $model->konfigtarifambulans_id),
    'Ubah',
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Konfigurasi Tarif Rumah Sakit</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial('_form', array('model' => $model)); ?>
    </div>
</div>