<div class="white-container">
    <legend class="rim2">Tambah <b>Konfigurasi Anggaran</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Agkonfiganggaran Ks'=>array('index'),
            'Create',
    );
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model,'format'=>$format)); ?>
</div>