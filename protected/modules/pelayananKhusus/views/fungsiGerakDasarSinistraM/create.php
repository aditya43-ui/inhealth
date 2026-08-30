
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Tambah <strong>Jenis Gerak Dasar</strong></div>
    </div>
    <div class="panel-body" style="overflow-x: scroll">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial($this->path_view.'_form', array('model' => $model)); ?>
    </div>
</div>
