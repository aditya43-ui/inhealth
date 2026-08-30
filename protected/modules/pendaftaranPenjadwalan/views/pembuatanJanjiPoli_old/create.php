<div class="white-container">
    <?php
    $this->breadcrumbs=array(
            'Ppbuat Janji Poli Ts'=>array('index'),
            'Create',
    );
    ?>
    <legend class="rim2">Buat <b>Janji Poli</b></legend>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_form', array('model'=>$model,'modPasien'=>$modPasien,'modPegawai'=>$modPegawai)); ?>
    <?php echo $this->renderPartial('_jsFunction', array('model'=>$model,'modPasien'=>$modPasien,'modPegawai'=>$modPegawai)); ?>
</div>
