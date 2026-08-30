<fieldset class="box">
    <legend class="rim2">Tambah Jadwal Dokter</legend>
    <?php
    $this->breadcrumbs=array(
            'Rdjadwaldokter Ms'=>array('index'),
            'Create',
    );
    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model,'listHari'=>$listHari)); ?>
</fieldset>