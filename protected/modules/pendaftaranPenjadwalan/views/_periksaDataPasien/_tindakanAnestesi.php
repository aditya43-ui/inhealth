<?php 
echo $this->renderPartial($this->path_view_pencarian.'persetujuanTindakan._listSuratKeteranganAnestesi', array(
    'pendaftaran_id'=>$pendaftaran_id,
    'tindakanAnestesi'=>true
), true);

if (!empty($modSuratPersetujuan)) {
    
    $model = PersetujuananestesiT::model()->findByAttributes(array(
        'persetujuananestesi_id'=>$modSuratPersetujuan->persetujuananestesi_id,
    ));
    
    $view = "_tindakanAnestesi";

    /*Ambil diagnosa*/
    $morbiditas = PasienmorbiditasT::model()->findByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id,'kelompokdiagnosa_id'=>Params::KELOMPOKDIAGNOSA_UTAMA),array('order'=>'pasienmorbiditas_id DESC'));
    $diagnosa = !empty($morbiditas->diagnosa_id)? $morbiditas->diagnosa->diagnosa_nama : "";
    
    echo $this->renderPartial($this->path_view_pencarian.'persetujuanTindakan.'.$view, array(
        'model' => $model,
        //'modPasienAnestesi' => $modPasienAnestesi,
        //'modPraAnestesi' => $modPraAnestesi,
        //'modTindakanAnestesi' => $modTindakanAnestesi,
        //'modObatAlkesAnestesi' => $modObatAlkesAnestesi,
        'modPendaftaran' => $modPendaftaran,
        'modPasien' => $modPasien,
        'format' => $format,
        'data' => $data,
        'diagnosa' => $diagnosa
    ), true);
}

