<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Kelompok Faktor Risiko</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'KelompokFaktorResiko Ms' => array('index'),
            $model->kelompokfaktorrisikodaftar_id => array('view', 'id' => $model->kelompokfaktorrisikodaftar_id),
            'Update',
        );

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial($this->path_view . '_form', array('model' => $model, 'modDet' => $modDet)); ?>
    </div>
</div>