<?php
$this->breadcrumbs = array(
    'Assep Ts' => array('index'),
    'Create',
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Approval Fingerprint BPJS</div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php 
        if (!empty($model->approvalfingerbpjs_id)) {
            $this->flashBpjs($model->approvalfingerbpjs_id);
        }
        ?>

        <?php echo $this->renderPartial('_form', array('model' => $model)); ?>
        <?php echo $this->renderPartial('_jsFunctions', array('model' => $model)); ?>
    </div>
</div>