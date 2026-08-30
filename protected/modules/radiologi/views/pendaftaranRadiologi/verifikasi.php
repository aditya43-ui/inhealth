<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial($this->path_view.'_view', array('model'=>$model, 'modPasienMasukPenunjang'=>$modPasienMasukPenunjang, 'modPasien'=>$modPasien, 'modPenanggungJawab'=>$modPenanggungJawab, 'modRujukan'=>$modRujukan, 'modTindakans'=>$modTindakans,'modKarcis'=>$modKarcis)); ?>
