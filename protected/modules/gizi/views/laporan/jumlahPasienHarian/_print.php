<?php
if($pilihanTab == 'rekap'){
    $this->renderPartial('gizi.views.laporan.jumlahPasienHarian/printRekap', array(
        'model' => $model,
        'models' => $modRekaps,
        'caraPrint' => $caraPrint,
        'judulLaporan' => $judulLaporan,
        'periodeLaporan' => $periodeLaporan
        )
    );
}else{
    $this->renderPartial('gizi.views.laporan.jumlahPasienHarian/printJumlah', array(
        'models' => $models,
        'caraPrint' => $caraPrint,
        'judulLaporan' => $judulLaporan,
        'periodeLaporan' => $periodeLaporan
            )
    );
}

?>