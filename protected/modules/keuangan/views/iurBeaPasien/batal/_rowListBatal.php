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
    if ($detail->is_approvalbatal) {
        if (!empty($detail->tgl_approvalbatal)) {
            echo MyFormatter::formatDateTimeForUser($detail->tgl_approvalbatal)."<br/>";
        }

        if (!empty($detail->pegawai_approvalbatal_id)) {
            $peg = PegawaiM::model()->findByPk($detail->pegawai_approvalbatal_id);
            if (!empty($peg)) {
                echo $peg->namaLengkap."<br/>";
            }
        }
        //echo $detail->is_approvalbatal == true ? "Sudah Approve" : "Belum Approve";
    } else {
        echo CHtml::link('<i class="icon-form-silang"></i>', '#', array(
            'onclick'=>'approveBatalBeaDialog('.$detail->iurbea_id.'); return false;',
            'rel'=>'tooltip',
            'title'=>'Klik untuk approve batal transaksi Iur Bea Pasien'
        ));
    }
    ?></td>
</tr>