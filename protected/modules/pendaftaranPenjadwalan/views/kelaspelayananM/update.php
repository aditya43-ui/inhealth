<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Kelas Pelayanan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Ppkelaspelayanan Ms' => array('index'),
            $model->kelaspelayanan_id => array('view', 'id' => $model->kelaspelayanan_id),
            'Update',
        );

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial('_formUpdate', array('model' => $model, 'modRuangan' => $modRuangan)); ?>
    </div>
</div>