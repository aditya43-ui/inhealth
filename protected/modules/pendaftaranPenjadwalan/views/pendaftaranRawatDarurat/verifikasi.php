<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial('pendaftaranPenjadwalan.views.pendaftaranRawatDarurat._view', array('model'=>$model, 'modPasien'=>$modPasien, 'modPenanggungJawab'=>$modPenanggungJawab, 'modRujukan'=>$modRujukan, 'modTindakan'=>$modTindakan,'modKecelakaan'=>$modKecelakaan)); ?>
