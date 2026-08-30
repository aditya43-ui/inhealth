<?php
    $this->widget('bootstrap.widgets.BootAlert');
    echo $this->renderPartial('konsultasiInternal/_dataPasien', 
        array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien)
    ); 
?>
<?php
    echo $this->renderPartial('konsultasiInternal/_permohonan', 
        array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'model' => $model, 'pasienMorbiditas' => $pasienMorbiditas)
    ); 
?>
<?php
    echo $this->renderPartial('konsultasiInternal/_jawaban', 
        array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'model' => $model, 'modUraian' => $modUraian, 'modMorbiditas' => $modMorbiditas)
    ); 
?>