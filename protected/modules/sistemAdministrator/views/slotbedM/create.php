<fieldset class="box">
    <legend class="rim2">Tambah Jadwal Bed</legend>
    <?php
    $this->breadcrumbs=array(
            'slotbed Ms'=>array('index'),
            'Create',
    );
    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model,'listHari'=>$listHari)); ?>
</fieldset>