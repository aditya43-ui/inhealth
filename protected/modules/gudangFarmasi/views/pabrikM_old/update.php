<div class="white-container">
    <legend class="rim2">Ubah <b>Pabrik</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Gfpabrik Ms'=>array('index'),
            $model->pabrik_id=>array('view','id'=>$model->pabrik_id),
            'Update',
    );

    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo $this->renderPartial('_form',array('model'=>$model)); ?>
</div>