<?php 

// echo '<pre>';var_dump(count($modObatAlkes) > 0);die;
if(count($modObatAlkes) > 0) {
    foreach($modObatAlkes as $data) {
        $this->renderPartial('_printEtiket', array(
            'modObatAlkes' => $data,
            'modPenjualanResep' => $modPenjualanResep,
            'modPasien' => $modPasien,
            'modPendaftaran' => $modPendaftaran
        ));
    }
}
?>