<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Provinsi</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Pppropinsi Ms' => array('index'),
            $model->propinsi_id => array('view', 'id' => $model->propinsi_id),
            'Update',
        );

        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial('_formUpdate', array('model' => $model)); ?>
    </div>
</div>