<?php
foreach ($grup_kirim as $instalasi_id => $item) {
    if (count($item['detail']) > 0) {
        echo "<strong>".$item['nama']."</strong> belum dilakukan verifikasi<br/>";

        foreach ($item['detail'] as $detail) {
            echo MyFormatter::formatDateTimeForUser($detail->tgl_kirimpasien)."<br>";
            echo "<ul>";
            $det = PermintaankepenunjangT::model()->findAllByAttributes(array(
                'pasienkirimkeunitlain_id'=>$detail->pasienkirimkeunitlain_id
            ));
            foreach ($det as $tindakan) {
                if (!empty($tindakan->pemeriksaanlab_id)) {
                    echo "<li>".($tindakan->pemeriksaanlab->pemeriksaanlab_nama ?? "-")."</li>";
                }
                if (!empty($tindakan->pemeriksaanrad_id)) {
                    echo "<li>".($tindakan->pemeriksaanrad->pemeriksaanrad_nama ?? "-")."</li>";
                }
                if (!empty($tindakan->operasi_id)) {
                    echo "<li>".$tindakan->operasi->operasi_nama."</li>";
                }
                if (!empty($tindakan->tindakanrm_id)) {
                    echo "<li>".$tindakan->tindakanrm->tindakanrm_nama."</li>";
                }
            }
            echo "</ul>";

            
        }
    }
}

if (count($reseptur) > 0) {
    echo "<strong>Reseptur</strong> belum dilakukan verifikasi<br/>";

    foreach ($reseptur as $item) {
        echo MyFormatter::formatDateTimeForUser($item->tglreseptur)." - ".$item->noresep."<br/>";
        $detail = ResepturdetailT::model()->findAllByAttributes(array(
            'reseptur_id'=>$item->reseptur_id,
        ), array(
            'order'=>'resepturdetail_id'
        ));

        echo "<ul>";
        foreach ($detail as $det) {
            echo "<li>";
            echo $det->obatalkes->obatalkes_nama." - ".$det->qty_reseptur." ".($det->satuankecil->satuankecil_nama ?? "");
            echo "</li>";
        }
        echo "</ul>";
    }
}


?>