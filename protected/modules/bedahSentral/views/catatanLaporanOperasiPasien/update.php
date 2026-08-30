<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Operasi</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial('_form', array(
            'model' => $model,
            'penunjang' => $penunjang,
            'rencana' => $rencana,
            'diagnosa' => $diagnosa,
            'anestesi' => $anestesi,
        )); ?>
    </div>
</div>