<div class="white-container">
    <legend class='rim2'>Ubah <b>Konfigurasi Anggaran</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Agkonfiganggaran Ks'=>array('index'),
            $model->konfiganggaran_id=>array('view','id'=>$model->konfiganggaran_id),
            'Update',
    );

    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model,'format'=>$format)); ?>
</div>