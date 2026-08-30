<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Materi Orientasi</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Materi Orientasi' => array('admin'),
            $model->materiorientasi_id => array('view', 'id' => $model->materiorientasi_id),
            'Ubah',
        );

        $arrMenu = array();
        $this->menu = $arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial($this->path_view.'_form', array('model' => $model)); ?>
    </div>
</div>