<?php
$this->breadcrumbs = array(
    'Faktorrisikodaftar Ms' => array('index'),
    $model->faktorrisiko_daftar_id => array('view', 'id' => $model->faktorrisiko_daftar_id),
    'Update',
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Daftar Faktor Risiko</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial($this->path_view . '_form', array('model' => $model)); ?>
    </div>
</div>