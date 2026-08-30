<?php
$this->breadcrumbs = array(
    'Kpkolomrating Ms' => array('index'),
    $model->kolomrating_id => array('view', 'id' => $model->kolomrating_id),
    'Update',
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Kolom Rating</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial('_form', array('model' => $model)); ?>
    </div>
</div>