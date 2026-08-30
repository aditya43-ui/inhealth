<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial($this->path_view.'_view', array('model'=>$model, 'modPasienMasukPenunjangs'=>$modPasienMasukPenunjangs, 'modPasien'=>$modPasien, 'modPenanggungJawab'=>$modPenanggungJawab, 'modRujukan'=>$modRujukan, 'modTindakans'=>$modTindakans,'modKarcis'=>$modKarcis,'modPengambilanSamples'=>$modPengambilanSamples)); ?>
