<tr>
    <td><?php echo $idx + 1; ?></td>
    <td><?php echo MyFormatter::formatDateTimeForUser($detail->tgl_transaksiiurbiaya); ?>/<br/><?php echo $detail->notransaksiiurbea; ?></td>
    <td><?php echo $pendaftaran->no_pendaftaran."/<br/>".$pendaftaran->pasien->no_rekam_medik; ?></td>
    <td><?php echo $pendaftaran->pasien->namadepan.$pendaftaran->pasien->nama_pasien; ?></td>
    <td class="num"><?php echo MyFormatter::formatNumberForPrint($detail->totalbiayarumahsakit, 2); ?></td>
    <td class="num"><?php echo MyFormatter::formatNumberForPrint($detail->inacbg_kelasperawatan, 2); ?></td>
    <td class="num"><?php echo MyFormatter::formatNumberForPrint($detail->inacbg_kelastanggungan, 2); ?></td>
    <td class="num"><?php echo MyFormatter::formatNumberForPrint($detail->totalselisihkelastanggunganperawatan, 2); ?></td>
    <td class="num"><?php echo MyFormatter::formatNumberForPrint($detail->iurbeatujuhpuluhpersen, 2); ?></td>
    <td class="num"><?php echo MyFormatter::formatNumberForPrint($detail->totalinacbg_naikkelasperawatan, 2); ?></td>
    <td style="text-align: center";><?php 
    
    $crAlo = new CDbCriteria;
    $crAlo->compare('t.pendaftaran_id', $detail->pendaftaran_id);
    $crAlo->addCondition('t.pasienadmisi_id is null');

    $is_alo = false;
    $alo = AlokasidanaT::model()->findByAttributes(array(
        'iurbea_id'=>$detail->iurbea_id
    ));

    if (!empty($alo)) {

        $tindakan = AlokasidanadetailtindakanT::model()->findByAttributes(array(
            'alokasidana_id'=>$alo->alokasidana_id
        ), array(
            'condition'=>"orderbatalalokasi_id is not null"
        ));
        $oa = AlokasidanadetailoaT::model()->findByAttributes(array(
            'alokasidana_id'=>$alo->alokasidana_id
        ), array(
            'condition'=>"orderbatalalokasi_id is not null"
        ));


        if (empty($tindakan) && empty($oa)) {
            $is_alo = true;
        }

    }



    

    
    if ($is_alo) {
        echo "Sudah dilakukan<br/>Alokasi Biaya.";
    } else {
        if ($detail->is_bataliurbea) {
            if (!empty($detail->tgl_bataltransaksiiurbea)) {
                echo MyFormatter::formatDateTimeForUser($detail->tgl_bataltransaksiiurbea)."<br/>";
            }
            echo $detail->is_approvalbatal == true ? "Sudah Approve" : "Belum Approve";
        } else {
            echo CHtml::link('<i class="icon-form-silang"></i>', '#', array(
                'onclick'=>'batalBeaDialog('.$detail->iurbea_id.'); return false;',
                'rel'=>'tooltip',
                'title'=>'Klik untuk membatalkan transaksi Iur Bea Pasien'
            ));
        }
    }
    ?></td>
</tr>