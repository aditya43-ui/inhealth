<head>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
</head>
<style>
    body{
        color: black !important;
    }
    h5{
        color: black !important;
    }
    label{
        color: black !important;
    }
    .tab_header {
        width: 100%;
    }
    .pilihan_ijin, .pilihan_privasi {
        font-weight: bold;
        cursor: pointer;
    }

    p {
        text-align: justify;
    }
    .borderclass {
        border: 1px solid black;
    }
    .bordertopclass {
        border-top: 1px solid black;
    }
    .borderrightclass {
        border-right: 1px solid black;
    }
    .borderleftclass {
        border-left: 1px solid black;
    }
    .borderbottomclass {
        border-bottom: 1px solid black !important;
    }

    .tab_header {
        width: 100%;
    }

    .tab_header td {
        vertical-align: top;
    }

    .tab_oa {
        width: 100%;
        border-collapse: collapse;
    }

    .tab_oa th, .tab_oa td {
        border: 1px solid black;
        padding: 2px;
    }

    .tab_layout td {
        vertical-align: top;
    }

    .borderclass {
        border: 1px solid black;
    }
    .bordertopclass {
        border-top: 1px solid black;
    }
    .borderrightclass {
        border-right: 1px solid black;
    }
    .borderleftclass {
        border-left: 1px solid black;
    }
    .borderbottomclass {
        border-bottom: 1px solid black !important;
    }
    .text-center{
        text-align: center !important;
    }
    .padding10 {
        padding: 10px;
    }
    .padding5 {
        padding: 5px;
    }
    /* @page { size: landscape; } */

    .divUtama{
        /* padding: 0 50px 0 50px; */
    }

    .fa{
        font-size: 11pt;
    }
</style>
<!-- "fa fa-check-square-o":"fa fa-square-o" -->
<!-- fa fa-dot-circle-o":"fa fa-circle-o -->
<br />
<?php echo $this->renderPartial($this->path_view . '_headerSurat', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien)); ?>
<br/> <br/>
<!-- <div class="divUtama"> -->
<table style="width: 100%">
    <thead>
        <tr>
            <th style="width: 50px" class="padding5 borderclass">No.</th>
            <th class="padding5 borderclass">Skrining</th>
            <th class="padding5 borderclass" style="width: 200px">Skor 1</th>
            <th class="padding5 borderclass" style="width: 200px">Skor 2</th>
            <th class="padding5 borderclass" style="width: 200px">Skor 3</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $skriningDet = array();
        $skriningDet[0] = array('nama_skrining' => 'Dikelola lebih dari 1 Dokter', 'skor_1_val' => 1, 'skor_1_label' => '1 Dokter', 'skor_2_val' => 2, 'skor_2_label' => '2 Dokter', 'skor_3_val' => 3, 'skor_3_label' => '> 2 Dokter');
        $skriningDet[1] = array('nama_skrining' => 'Harus dilakukan tindakan resiko', 'skor_1_val' => 1, 'skor_1_label' => 'ringan', 'skor_2_val' => 2, 'skor_2_label' => 'sedang', 'skor_3_val' => 3, 'skor_3_label' => 'berat');
        $skriningDet[2] = array('nama_skrining' => 'Penyakit kronis, kasus kompleks/ rumit dll', 'skor_1_val' => 1, 'skor_1_label' => 'Sederhana/ Simple', 'skor_2_val' => 2, 'skor_2_label' => 'Kompleks', 'skor_3_val' => 3, 'skor_3_label' => 'Sangat Kompleks');
        $skriningDet[3] = array('nama_skrining' => 'LOS > 3 Hari', 'skor_1_val' => 1, 'skor_1_label' => '< 5 hari', 'skor_2_val' => 2, 'skor_2_label' => '5 - 7 hari', 'skor_3_val' => 3, 'skor_3_label' => '> 7 hari');
        $skriningDet[4] = array('nama_skrining' => 'Potensial Komplain', 'skor_1_val' => 1, 'skor_1_label' => 'Kecil', 'skor_2_val' => 2, 'skor_2_label' => 'Sedang', 'skor_3_val' => 3, 'skor_3_label' => 'Tinggi');
        $skriningDet[5] = array('nama_skrining' => 'Potensial Biaya Tinggi', 'skor_1_val' => 1, 'skor_1_label' => '< 5 Juta', 'skor_2_val' => 2, 'skor_2_label' => '5 - 10 Juta', 'skor_3_val' => 3, 'skor_3_label' => '> 10 Juta');
        $skriningDet[6] = array('nama_skrining' => 'Masalah Pembiayaan Kompleks', 'skor_1_val' => 1, 'skor_1_label' => 'Tidak ada - Kecil', 'skor_2_val' => 2, 'skor_2_label' => 'Kecil - Sedang', 'skor_3_val' => 3, 'skor_3_label' => 'Sedang - Besar');
        $skriningDet[7] = array('nama_skrining' => 'Pontensial cacat organ', 'skor_1_val' => 1, 'skor_1_label' => 'Kecil', 'skor_2_val' => 2, 'skor_2_label' => 'Sedang', 'skor_3_val' => 3, 'skor_3_label' => 'Besar');
        $skriningDet[8] = array('nama_skrining' => 'Kasus yang diidentifikasi rencana pemulangan kritis atau yang membutuhkan kontinuitas pelayanan', 'skor_1_val' => 1, 'skor_1_label' => '', 'skor_2_val' => 2, 'skor_2_label' => '', 'skor_3_val' => 3, 'skor_3_label' => '');

        if (count($skriningDet) > 0) {
            $indexDet = 1;
            foreach ($skriningDet as $i => $skrDet) {
                if (count($modSkriningDet) > 0) {
                    $isskrining1 = false;
                    $isskrining2 = false;
                    $isskrining3 = false;
                    $namalainnyaskrining1 = "";
                    $namalainnyaskrining2 = "";
                    $namalainnyaskrining3 = "";

                    foreach ($modSkriningDet as $skrinningOri) {

                        if ($skrinningOri->nama_skrining == $skrDet['nama_skrining']) {
                            if ($skrinningOri->nilai_skor == $skrDet['skor_1_val']) {
                                $isskrining1 = true;
                                if ($skrinningOri->nama_skrining == "Kasus yang diidentifikasi rencana pemulangan kritis atau yang membutuhkan kontinuitas pelayanan") {
                                    $namalainnyaskrining1 = $skrinningOri->nilai_skrining;
                                }
                            }

                            if ($skrinningOri->nilai_skor == $skrDet['skor_2_val']) {
                                $isskrining2 = true;
                                if ($skrinningOri->nama_skrining == "Kasus yang diidentifikasi rencana pemulangan kritis atau yang membutuhkan kontinuitas pelayanan") {
                                    $namalainnyaskrining2 = $skrinningOri->nilai_skrining;
                                }
                            }

                            if ($skrinningOri->nilai_skor == $skrDet['skor_3_val']) {
                                $isskrining3 = true;
                                if ($skrinningOri->nama_skrining == "Kasus yang diidentifikasi rencana pemulangan kritis atau yang membutuhkan kontinuitas pelayanan") {
                                    $namalainnyaskrining3 = $skrinningOri->nilai_skrining;
                                }
                            }
                        }
                    }
                }
                ?>
                <tr>
                    <td class="padding5 borderclass"><?php echo $indexDet . '.'; ?> </td>
                    <td class="padding5 borderclass">
                        <?php echo $skrDet['nama_skrining']; ?>
                    </td>
                    <td class="padding5 borderclass">
                        <span class="<?php echo (($isskrining1) ? "fa fa-dot-circle-o" : "fa fa-circle-o"); ?>"></span>
                        <?php if (!empty($skrDet['skor_1_label'])) {
                            ?>
                            <label><?php echo $skrDet['skor_1_label']; ?></label>
                            <?php
                        } else {
                            echo "<label>" . $namalainnyaskrining1 . "</label>";
                        }
                        ?>

                    </td>
                    <td class="padding5 borderclass">
                        <span class="<?php echo (($isskrining2) ? "fa fa-dot-circle-o" : "fa fa-circle-o"); ?>"></span>
                        <?php if (!empty($skrDet['skor_2_label'])) {
                            ?>
                            <label><?php echo $skrDet['skor_2_label']; ?></label>
                            <?php
                        } else {
                            echo "<label>" . $namalainnyaskrining2 . "</label>";
                        }
                        ?>
                    </td>
                    <td class="padding5 borderclass">
                        <span class="<?php echo (($isskrining3) ? "fa fa-dot-circle-o" : "fa fa-circle-o"); ?>"></span>
                        <?php if (!empty($skrDet['skor_3_label'])) {
                            ?>
                            <label><?php echo $skrDet['skor_3_label']; ?></label>
                            <?php
                        } else {
                            echo "<label>" . $namalainnyaskrining3 . "</label>";
                        }
                        ?>
                    </td>
                </tr>
                <?php
                $indexDet++;
            }
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td class="borderclass padding5" colspan="2" style="text-align: center">Jumlah Skor</td>
            <td class="borderclass padding5" colspan="3" style="text-align: center"><?php echo $model->jumlahskor; ?></td>
        </tr>
    </tfoot>
</table>
<br />
<table width="100%">
    <?php
    $modJenisSkrining = JenisskriningM::model()->findAllByAttributes(array('status_jenisskringin' => true), array('order' => 'urutan_skrining ASC'));
    if (count($modJenisSkrining) > 0) {
        $jenisPeriksa = '';
        $indexData = 0;
        $indexMast = 0;
        $dataText = 0;
        $sizeTd = 1;

        foreach ($modJenisSkrining as $i => $masterJnsSkrining) {
            $indexData += 4;
            $modDataSkriningM = DataskriningM::model()->findAllByAttributes(array('status_dataskrining' => true, 'jenisskrining_id' => $masterJnsSkrining->jenisskrining_id), array('order' => 'urutan_skrining ASC'));

            if ($sizeTd == 1) {
                ?>
                <tr>
                    <?php
                }
                ?>
                <td width="15%" valign="top">
                    <table width="100%">
                        <tr>
                            <td class="borderclass padding5">
                                <strong><?php echo $masterJnsSkrining->nama_jenisskrining; ?></strong>
                            </td>
                        </tr>
                        <tr>
                            <td class="borderclass padding5">
                                <table width="100%">
                                    <?php
                                    if (count($modDataSkriningM) > 0) {
                                        foreach ($modDataSkriningM as $masterDataSkrining) {
                                            $isPrenc = false;
                                            $textLainnya = "";

                                            if (count($modPerencanaanEvaluasi) > 0) {
                                                foreach ($modPerencanaanEvaluasi as $perencanaan) {
                                                    if ($perencanaan->dataskrining_id == $masterDataSkrining->dataskrining_id) {
                                                        $isPrenc = true;
                                                        $textLainnya = $perencanaan->nama_lainnya;
                                                    }
                                                }
                                            }
                                            ?>
                                            <tr>
                                                <td class="padding5">
                                                    <span class="<?php echo (($isPrenc) ? "fa fa-check-square-o" : "fa fa-square-o"); ?>"></span>
                                                    <?php
                                                    if (strtolower($masterDataSkrining->nama_skrining) == 'lainnya') {
                                                        echo $textLainnya;
                                                    } else {
                                                        echo $masterDataSkrining->nama_skrining;
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>

                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
                <?php
                if ($sizeTd == 6) {
                    ?>
                </tr>
                <?php
                $sizeTd = 0;
            }
            $sizeTd += 1;
            ?>


            <?php
            // if($indexData == 12){
            //     $indexData =0;
            //     echo '<div class="clear"></div>';
            // }
        }
    }
    ?>
</table>


<table width="100%">
    <tr>
        <td style="width:70%; text-align: left;" colspan="2">
        </td>
        <td style="text-align: left;" colspan="2" nowrap>
            <center>Singaraja, <?php echo MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s')); ?> WITA</center>
        </td>
    </tr>
    <tr>
        <td style="width:70%; text-align: left;" colspan="2">
        </td>
        <td colspan="2" >
            <center>Petugas Pengisi
                <br><br><br><br><br><br>
                <?php echo $model->petugaspengisi->namaLengkap; ?>
            </center>
        </td>
    </tr>
</table>

<?php if (empty($caraPrint)) { 
    echo CHtml::link('Kembali', $this->createUrl('riwayat', array(
        'pasien_id'=>$model->pasien_id,
        'frame'=>1
    )), array(
        'class'=>'btn btn-danger'
    ));
}
?>
<br/>
