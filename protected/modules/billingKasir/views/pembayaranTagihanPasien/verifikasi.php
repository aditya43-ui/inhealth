<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial($this->path_view.'_view', array(
    'modKunjungan'=>$modKunjungan,
    'model'=>$model,
    'modTandabukti'=>$modTandabukti,
    'modPemakaianuangmuka'=>$modPemakaianuangmuka,
    'admisi'=>$admisi,
    'modJenisPembayaran'=>$modJenisPembayaran
)); ?>
