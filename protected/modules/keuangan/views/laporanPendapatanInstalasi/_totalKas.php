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
           if($totals->carapembayaran == "TUNAI" && $totals->carabayar_id == Params::CARABAYAR_ID_MEMBAYAR){
               $totTarif += $totals->totaliurbiaya;
           }else{
               $totTarif = 0;
           }
       }
       if(isset($caraPrint)){
           echo $totTarif;
       }else{
           if (!empty($footer)){
                echo $totTarif;
            }else{
                echo number_format($totTarif,0,"",".");
            }
       }
    }
    
?>