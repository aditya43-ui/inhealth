<?php
$admisi = PasienadmisiT::model()->findByPk($data->pasienadmisi_id);
?>
<tr>
    <td>
        <?php echo MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran) . "/<br/>" . $data->no_pendaftaran; ?>
    </td>
    <td>
        <?php
        echo CHtml::link("<i class='icon-form-anamnesa'></i> ",  Yii::app()->createUrl(
            "/rekamMedis/pencarianPasienRK/detailAnamnesa",
            array("id" => $data->pendaftaran_id)
        ), array("id" => "$data->no_pendaftaran", "target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail Anamnesis", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat Pelayanan/Anamnesis"));
        ?>
    </td>
    <td>
        <?php
        $modMasukPenunjang = RJPasienMasukPenunjangT::model()->with('ruangan')->findAllByAttributes(array('pendaftaran_id' => $data->pendaftaran_id));
        $jumlah = count($modMasukPenunjang);
        $result = "";
        foreach ($modMasukPenunjang as $row) {
            $modHasilLab = RJHasilpemeriksaanlabT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $row->pasienmasukpenunjang_id));
            $modHasilRad = HasilpemeriksaanradT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $row->pasienmasukpenunjang_id));
            if ($modHasilLab) { //cek jika sudah ada hasil lab
                $result .= "" . CHtml::link("<i class='icon-form-detail'></i> ", Yii::app()->createUrl("/rekamMedis/pencarianPasienRK/detailHasilLab", array("pendaftaran_id" => $data->pendaftaran_id, "pasien_id" => $data->pasien_id, "pasienmasukpenunjang_id" => $row->pasienmasukpenunjang_id)), array("id" => "$data->no_pendaftaran", "target" => "pesan", "rel" => "tooltip", "title" => "Klik untuk Detail Hasil Pemeriksaan '" . $row->ruangan->ruangan_nama . "'", "onclick" => "window.parent.$('#dialogDetailHasilLab').dialog('open');")) . "<br>";
            } elseif ($modHasilRad) { //jika radiologi
                $result .= "" . CHtml::link("<i class='icon-form-detail'></i> ", Yii::app()->createUrl("/rekamMedis/pencarianPasienRK/detailHasilRad", array("pendaftaran_id" => $data->pendaftaran_id, "pasien_id" => $data->pasien_id, "pasienmasukpenunjang_id" => $row->pasienmasukpenunjang_id)), array("id" => "$data->no_pendaftaran", "target" => "pesan", "rel" => "tooltip", "title" => "Klik untuk Detail Hasil Pemeriksaan '" . $row->ruangan->ruangan_nama . "'", "onclick" => "window.parent.$('#dialogDetailHasilLab').dialog('open');")) . "<br>";
            } else {
                $result .= "<br>";
            }
        }
        echo $result;
        ?></ul>
    </td>
    </td>
    <td>
        <?php //if (count($modKunjungan->tindakanpelayanan->daftartindakan_id) != 0){
        echo CHtml::link("<i class='icon-form-tindakan'></i> ",  Yii::app()->createUrl(
            "/rekamMedis/pencarianPasienRK/detailTindakan",
            array("id" => $data->pendaftaran_id)
        ), array("id" => "$data->no_pendaftaran", "target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail Tindakan", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat Pelayanan/Tindakan"));
        echo " ";
        echo CHtml::link("<i class='icon-form-terapi'></i> ",  Yii::app()->controller->createUrl(
            "/rekamMedis/pencarianPasienRK/detailTerapi",
            array("id" => $data->pendaftaran_id)
        ), array("id" => "$data->no_pendaftaran", "target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail Terapi", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat Resep Dokter/Terapi"));
        echo " ";
        echo CHtml::link("<i class='icon-form-pakaibahan'></i> ",  Yii::app()->createUrl(
            "/rekamMedis/pencarianPasienRK/detailPemakaianBahan",
            array("id" => $data->pendaftaran_id)
        ), array("id" => "$data->no_pendaftaran", "target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail Terapi", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat Pemakaian Bahan"));
        ?>
    </td>
    <td>
        <?php
        $modMorbiditas = PasienmorbiditasT::model()->with('diagnosa')->findAllByAttributes(array('pendaftaran_id' => $data->pendaftaran_id));
        $jumlahMorbiditas = count($modMorbiditas);
        $result = array();
        foreach ($modMorbiditas as $row) {
            $result[] = $row->diagnosa->diagnosa_nama;
        }
        echo implode(', ', $result);
        ?>
    </td>
</tr>