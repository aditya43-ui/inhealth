<div class="white-container">
    <legend class="rim2">Ubah <b>Pengumuman</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sapengumumen'=>array('index'),
            $model->pengumuman_id=>array('view','id'=>$model->pengumuman_id),
            'Update',
    );

    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo $this->renderPartial($this->view_path.'_form',array('model'=>$model)); ?>
</div>