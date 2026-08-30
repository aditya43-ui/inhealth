<?php
$this->breadcrumbs = array(
    'Kppengangkatanpns Ts' => array('index'),
    'Create',
);
?>


<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Pengangkatan <b>PNS</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial('_form', array('model' => $model, 'modPegawai' => $modPegawai, 'modUsulan' => $modUsulan, 'modPers' => $modPers, 'modRealisasi' => $modRealisasi)); ?>
        <!--/div-->
    </div>
</div>