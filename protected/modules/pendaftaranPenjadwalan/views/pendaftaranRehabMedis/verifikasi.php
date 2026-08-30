<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial($this->path_view.'_view', array('model'=>$model, 'modPasien'=>$modPasien, 'modPenanggungJawab'=>$modPenanggungJawab, 'modRujukan'=>$modRujukan, 'modTindakan'=>$modTindakan)); ?>
