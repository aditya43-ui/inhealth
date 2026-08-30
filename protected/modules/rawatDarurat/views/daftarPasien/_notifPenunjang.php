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

if (count($oaTriage2) > 0) {
    echo "<strong>Reseptur Triage</strong> belum dilakukan verifikasi<br/>";

    $arr_triage = array();
    foreach ($oaTriage2 as $item) {
        if (empty($arr_triage[$item->noresep_triage])) {
            $arr_triage[$item->noresep_triage] = array();
        }
        $arr_triage[$item->noresep_triage][] = $item;
    }

    echo "<ul>";
    foreach ($arr_triage as $no_resep => $item) {
        echo "<li>".$no_resep;
        echo "<ul>";
        foreach ($item as $det) {
            $oa = ObatalkesM::model()->findByPk($det->obatalkes_id);
            echo "<li>";
            echo $oa->obatalkes_nama."(".$det->jumlah.")";
            echo "</li>";
        }
        echo "</ul>";
        echo "</li>";
    }

    echo "</ul>";
}

if(empty($modResume)) {
    echo '<br>';
    echo '<strong>Resume medis belum diterbitkan oleh dokter</strong><br/>';
}



?>