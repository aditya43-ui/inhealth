<?php
$this->breadcrumbs = array(
    'Biaya Lembur' => array('admin'),
    $model->biayalembur_id => array('view', 'id' => $model->biayalembur_id),
    'Update',
);

?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Update Biaya Lembur
        </div>
    </div>
    <div class="panel-body">
        <?php echo $this->renderPartial('_form', array('model' => $model)); ?>
    </div>
</div>