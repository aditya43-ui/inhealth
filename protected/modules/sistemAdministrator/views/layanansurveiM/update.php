<?php
$this->breadcrumbs = array(
    'Layanansurvei Ms' => array('index'),
    $model->layanansurvei_id => array('view', 'id' => $model->layanansurvei_id),
    'Update',
);

$this->menu = array(
    array('label' => 'List LayanansurveiM', 'url' => array('index')),
    array('label' => 'Create LayanansurveiM', 'url' => array('create')),
    array('label' => 'View LayanansurveiM', 'url' => array('view', 'id' => $model->layanansurvei_id)),
    array('label' => 'Manage LayanansurveiM', 'url' => array('admin')),
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Layanan Survei</b>
        </div>
    </div>
    <div class="panel-body">
        <?php echo $this->renderPartial('_form', array('model' => $model)); ?>
    </div>
</div>