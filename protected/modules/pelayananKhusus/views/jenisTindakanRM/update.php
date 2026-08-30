<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Ubah Jenis <b> Tindakan Rekam Medik</b></div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>
    </div>
</div>