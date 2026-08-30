<div class="white-container">
    <legend class="rim2">Tambah <b>Komponen Gaji</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Komponen Gaji'=>array('admin'),
            'Tambah',
    );
    
    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>