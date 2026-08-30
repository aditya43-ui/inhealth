<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Grafik Tanda Vital</div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial($this->path_view .'_form', array('model'=>$model)); ?>
        <?php echo $this->renderPartial($this->path_view .'_grafik', array('riwayat'=>$riwayat)); ?>
        <?php echo $this->renderPartial($this->path_view .'_riwayat', array('riwayat'=>$riwayat,'model'=>$model)); ?>
    </div>
</div>