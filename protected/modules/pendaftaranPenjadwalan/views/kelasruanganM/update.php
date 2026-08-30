<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Kelas Ruangan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Ppruangan Ms' => array('index'),
            $model->ruangan_id => array('view', 'id' => $model->ruangan_id),
            'Update',
        );

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial('_formUpdate', array('model' => $model, 'modRuangan' => $modPelayanan)); ?>
    </div>
</div>