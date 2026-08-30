<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Golongan Umur</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Ppgolonganumur Ms' => array('index'),
            $model->golonganumur_id => array('view', 'id' => $model->golonganumur_id),
            'Update',
        );

        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial('_formUpdate', array('model' => $model)); ?>
    </div>
</div>