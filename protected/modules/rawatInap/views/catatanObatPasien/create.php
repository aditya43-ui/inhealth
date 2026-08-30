<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Catatan Obat Pasien</div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model, 'kunjungan'=>$kunjungan, 'riwayat'=>$riwayat), true); ?>

    </div>
</div>
