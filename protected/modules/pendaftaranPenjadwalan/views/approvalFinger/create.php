<?php
$this->breadcrumbs = array(
    'Assep Ts' => array('index'),
    'Create',
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Buat Pengajuan Approval <b>(SEP)</b></div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial('_form', array('model' => $model, 'modInfoKunjungan' => $modInfoKunjungan,)); ?>
        <?php echo $this->renderPartial('_jsFunctions', array('model' => $model)); ?>
    </div>
</div>