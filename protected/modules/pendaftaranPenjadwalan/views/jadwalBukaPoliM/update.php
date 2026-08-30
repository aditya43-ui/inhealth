<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Jadwal Buka Poli</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Jadwal Buka Poli' => array('index'),
            $model->jadwalbukapoli_id => array('view', 'id' => $model->jadwalbukapoli_id),
            'Ubah',
        );

        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial('_formUpdate', array('model' => $model)); ?>
    </div>
</div>