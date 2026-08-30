<?php
$this->breadcrumbs = array(
    'Penyertaetilogi Ms' => array('index'),
    $model->penyertaetilogi_id => array('view', 'id' => $model->penyertaetilogi_id),
    'Update',
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Penyerta Etilogi</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial('_form', array('model' => $model)); ?>
    </div>
</div>