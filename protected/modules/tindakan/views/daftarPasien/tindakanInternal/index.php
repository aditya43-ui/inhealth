<?php
    $this->widget('bootstrap.widgets.BootAlert');
    echo $this->renderPartial('tindakanInternal/_dataPasien', 
        array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien)
    ); 
?>
<?php
    echo $this->renderPartial('tindakanInternal/_permohonan', 
        array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'model' => $model, 'pasienMorbiditas' => $pasienMorbiditas)
    ); 
?>
<?php
    echo $this->renderPartial('tindakanInternal/_jawaban', 
        array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'model' => $model, 'modUraian' => $modUraian, 'modMorbiditas' => $modMorbiditas)
    ); 
?>