<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Jenis Pemeriksaan Lab</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Sajenispemeriksaanlab Ms' => array('index'),
            $model->subjenis_pemeriksaanlab_id => array('view', 'id' => $model->subjenis_pemeriksaanlab_id),
            'Update',
        );
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial($this->path_view . '_form', array('model' => $model)); ?>
    </div>
</div>