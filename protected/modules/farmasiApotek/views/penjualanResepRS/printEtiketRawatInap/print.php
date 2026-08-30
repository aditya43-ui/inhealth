<?php 
$modPasien = $modPenjualan->pasien;
$modPendaftaran = $modPenjualan->pendaftaran;
$modReseptur = $modPenjualan;
if(count($dataObat) > 0) {
    foreach($dataObat as $i => $data) {
        if(count($data) > 0) {
            foreach($data as $ii => $val) {
                if($val['racikan_id'] == Params::RACIKAN_ID_NONRACIKAN) {
                    $this->renderPartial('printEtiketRawatInap/nonRacikan', ['obat' => $val, 'modPenjualan' => $modPenjualan, 'modPasien' => $modPasien, 'modPendaftaran' => $modPendaftaran, 'modReseptur' => $modReseptur]);
                } else {
                    $this->renderPartial('printEtiketRawatInap/racikan', ['obat' => $val, 'modPenjualan' => $modPenjualan, 'modPasien' => $modPasien, 'modPendaftaran' => $modPendaftaran, 'modReseptur' => $modReseptur]);
                }
            }
        }
    }
}
?>