<?php
$this->breadcrumbs = array(
    'Kpindikatorperilaku Ms' => array('index'),
    $model->indikatorperilaku_id => array('view', 'id' => $model->indikatorperilaku_id),
    'Update',
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Indikator Perilaku</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial('_form', array('model' => $model)); ?>
    </div>
</div>