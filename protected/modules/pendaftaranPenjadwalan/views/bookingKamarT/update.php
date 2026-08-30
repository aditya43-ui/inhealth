<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Data Pesan Kamar</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial($this->path_view . '_formUpdate', array('model' => $model)); ?>
    </div>
</div>