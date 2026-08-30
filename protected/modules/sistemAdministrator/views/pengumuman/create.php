<div class="white-container">
    <legend class="rim2">Tambah <b>Pengumuman</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sapengumumen'=>array('index'),
            'Create',
    );
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial($this->view_path.'_form', array('model'=>$model)); ?>
</div>