<div class="white-container">
    <?php
    $this->breadcrumbs=array(
            'Pcobatalkesdetail Ms'=>array('index'),
            $model->obatalkesdetail_id=>array('view','id'=>$model->obatalkesdetail_id),
            'Update',
    );

    ?>
    <legend class="rim2">Ubah <b>Data Obat</b></legend>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo $this->renderPartial('_form',array('model'=>$model)); ?>
</div>