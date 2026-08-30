<?php
$this->breadcrumbs = array(
    'Luluskomponendarah Ts' => array('index'),
    'Create',
);
?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    Pelulusan <b>Komponen Darah</b>
                </div>
            </div>
            <div class="panel-body">
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

                <?php echo $this->renderPartial('_form', array(
                    'model' => $model,
                    'modKantong' => $modKantong,
                    'modKantongDarah' => $modKantongDarah,
                )); ?>
            </div>