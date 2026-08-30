<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Jenis Penjamin</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Ppcarabayar Ms' => array('index'),
            $model->carabayar_id => array('view', 'id' => $model->carabayar_id),
            'Update',
        );

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial('_formUpdate', array('model' => $model)); ?>
    </div>
</div>