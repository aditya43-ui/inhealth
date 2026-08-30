<?php 
    if(count($modPenyiapan) > 0) {
        foreach ($modPenyiapan as $i => $data) {
            $this->renderPartial('printLabel', array(
                'modPendaftaran' => $modPendaftaran,
                'modPenyiapan' => $data,
                'modPenunjang' => $modPenunjang,
                'modKirimUnit' => $modKirimUnit
            ));
        }
    }
?>