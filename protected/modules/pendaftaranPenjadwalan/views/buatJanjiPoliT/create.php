<?php
$this->widget('bootstrap.widgets.BootAlert'); ?>

    <legend class="rim2">Buat Janji Poli</legend>

    <?php echo $this->renderPartial($this->path_view.'_form', array('modPasien'=>$modPasien,'modPPBuatJanjiPoli'=>$modPPBuatJanjiPoli
)); ?>

