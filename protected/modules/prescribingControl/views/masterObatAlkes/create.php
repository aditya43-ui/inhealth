<div class="white-container">
    <?php
    $this->breadcrumbs=array(
            'Pcobatalkesdetail Ms'=>array('index'),
            'Create',
    );
    ?>
    <legend class="rim2">Tambah <b>Obat</b></legend>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>