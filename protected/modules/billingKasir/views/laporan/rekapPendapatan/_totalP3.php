<?php
    if(empty($pendaftaran_id) || empty($tglpembayaran)){
        echo '-';
    }else{
        $format = new MyFormatter();
        $tgl = $format->formatDateTimeForDb($tglpembayaran);
        $modTotal = LaporanrekappendapatanV::model()->findAllByAttributes(array(
            'pendaftaran_id'=>$pendaftaran_id,
            'tglpembayaran'=>$tgl
        ));
        $totTarif = 0;

        foreach($modTotal as $key=>$totals){
           $cekStatus = CarabayarM::model()->findByPk($totals->carabayar_id);
           if($totals->carapembayaran == "PIUTANG" && ($totals->carabayar_id != Params::CARABAYAR_ID_MEMBAYAR || $totals->carapembayaran == "TUNAI" ) ){
               if ($cekStatus->issubsidiasuransi == TRUE){
                    $totTarif += $totals->totalsubsidiasuransi;
               }elseif($cekStatus->issubsidipemerintah == TRUE){
                    $totTarif += $totals->totalsubsidipemerintah;
               }else{
                $totTarif = 0;
               }
           }else{
               $totTarif = 0;
           }
       }
       if(isset($caraPrint)){
           echo $totTarif;
       }else{
        echo number_format($totTarif,0,"",".");
       }
    }
    
?>