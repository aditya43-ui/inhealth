<?php
$modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
$morbid = PasienmorbiditasT::model()->findAllByAttributes(array(
    'pendaftaran_id'=>$pendaftaran_id,
    // 'kelompokdiagnosa_id'=>Params::KELOMPOKDIAGNOSA_UTAMA,
));

$morbid_res = array();
foreach ($morbid as $item) {
    if (empty($morbid_res[$item->ruangan_id])) {
        $morbid_res[$item->ruangan_id] = array();
    }
    $morbid_res[$item->ruangan_id][] = $item;
}

if(!empty($modPendaftaran)){
    if(count((array)$morbid) > 0) {
        foreach ($morbid_res as $ruangan_id => $item) {
            $ruangan = RuanganM::model()->findByPk($ruangan_id);
            echo $ruangan->ruangan_nama."<br>";
            echo "Keterangan Diagnosa". ":<br><ul>";
            foreach ($item as $detail) {
                echo "<li>".$detail->diagnosa->diagnosa_kode." ".$detail->diagnosa->diagnosa_nama."</li>";
                // echo "<li>".$detail->ket_diagnosa."</li>";
            }
            echo "</ul>";
        }
    }
    if(!empty($modPendaftaran->rujukan_id)){
            echo "Rujukan : <br>";
            $modRujukan = RujukanT::model()->findByPk($modPendaftaran->rujukan_id);
            echo (isset($modRujukan->kddiagnosa_rujukan) ? $modRujukan->kddiagnosa_rujukan : "")." - ".(isset($modRujukan->diagnosa_rujukan) ? $modRujukan->diagnosa_rujukan : "");
    }
}
?>