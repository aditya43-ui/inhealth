<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Cara Masuk</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Ppcaramasuk Ms' => array('index'),
            $model->caramasuk_id => array('view', 'id' => $model->caramasuk_id),
            'Update',
        );

        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial('_formUpdate', array('model' => $model)); ?>
    </div>
</div>