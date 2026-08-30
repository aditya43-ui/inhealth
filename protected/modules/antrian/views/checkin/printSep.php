<?php

echo $this->render('printSep_ekios', array(
    'format' => $format,
    'modSep' => $modSep,
    'judul_print' => $judul_print,
    'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs,
    'modRujukanBpjs' => $modRujukanBpjs,
    'modPendaftaran' => $modPendaftaran,
    'modPasien' => $modPasien,
    'modJenisPeserta' => $modJenisPeserta,
    'modRujukan' => $modRujukan,
), true);

echo '<br/><hr style="border-top: 1px solid black;" >';

echo $this->render('printKlaim', array(
    'modPendaftaran' => $modPendaftaran,
    'modPasien' => $modPasien,
    'modAsuransi'   => $modAsuransi,
    'modPenanggungjawab' => $modPenanggungjawab,
    'format'=>$format,
    'modPegawai' => $modPegawai,

    //'model' => $model,
    //'judulLaporan' => $judulLaporan,
    //'caraPrint' => $caraPrint
));

?>