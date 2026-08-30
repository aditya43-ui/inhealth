<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Tambah <strong>Pengkajian Nyeri</strong></div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model)); ?>

    </div>
</div>