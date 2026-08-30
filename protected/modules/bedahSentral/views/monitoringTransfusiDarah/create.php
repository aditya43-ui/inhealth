<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-monitor"></i> Monitoring <b>Transfusi Darah</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial('_infoPasien', array('model' => $daftar)); ?>
        <?php echo $this->renderPartial('_riwayat', array('model' => $model, 'riwayat' => $riwayat)); ?>
        <?php echo $this->renderPartial('_form', array('model' => $model)); ?>
    </div>
</div>