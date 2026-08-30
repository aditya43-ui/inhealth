<?php 
echo $this->renderPartial($this->path_view_pencarian.'persetujuanTindakan._listPersetujuanTindakan', array(
    'pendaftaran_id'=>$pendaftaran_id,
    'informConsent'=>true
), true);

if (!empty($modSuratPersetujuan)) {
    
    $inform = InformconsentT::model()->findByAttributes(array(
        'suratpersetujuantm_id'=>$modSuratPersetujuan->suratpersetujuantm_id,
    ));
    
    if (!empty($inform)) {
        
        $inform->informasi_tindakan_medis = CJSON::decode($inform->informasi_tindakan_medis);
        
        echo $this->renderPartial($this->path_view_pencarian.'persetujuanTindakan._informConsent', array(
            'model' => $modSuratPersetujuan,
            'inform'=> $inform,
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'format' => $format,
            'data' => $data
        ), true);
    } else {
    
        $view = "_penerimaan";
        if ($modSuratPersetujuan->jenissurat == Params::SURAT_PERSETUJUAN_PENOLAKAN) {
            $view = "_penolakan";
        }

        echo $this->renderPartial($this->path_view_pencarian.'persetujuanTindakan.'.$view, array(
            'modSuratPersetujuan' => $modSuratPersetujuan,
            //'modPasienAnestesi' => $modPasienAnestesi,
            //'modPraAnestesi' => $modPraAnestesi,
            //'modTindakanAnestesi' => $modTindakanAnestesi,
            //'modObatAlkesAnestesi' => $modObatAlkesAnestesi,
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'format' => $format,
            'data' => $data
        ), true);
    }
}

