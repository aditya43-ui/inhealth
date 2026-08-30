<?php
$hide = '';
$headThorax = 'Pemeriksaan Thorax';
if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_POLIK_GIGI) {
    $hide = 'hidden';
    $headThorax = 'Tanda Vital';
}
?>

<head>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
</head>
<style>
    table.border tr td {
        border: 1px solid #000;
        vertical-align: top;
        /*        padding: 5px;*/
    }

    .barcode-label {
        margin-top: -20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }

    td,
    th {
        /*        font-size: 8pt !important;*/
        height: 20px;
        /*        padding-left:10px;*/
    }

    body {
        /*        width: 21.7cm;*/
    }

    .content td {
        /*        height: 32px;*/
    }

    #imgtag {
        position: relative;
        min-width: 300px;
        min-height: 300px;
        float: none;
        border: 3px solid #FFF;
        cursor: crosshair;
        /*text-align: center;*/
    }
</style>
<?php //echo $this->renderPartial($this->path_view.'_headerPrint'); 
?>
<div style="padding: 5px;">
    <div class="header">
        <?php echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());?>
    </div>
    <div>
        <table width="100%" border="1">
            <tr>
                <td style="width:20%">SMF</td>
                <td style="width:30%"><?php echo $modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama; ?></td>
                <td style="width:20%">NO. RM</td>
                <td style="width:30%"><?php echo $modPasien->no_rekam_medik; ?></td>
            </tr>
            <tr>
                <td style="width:20%">Nama</td>
                <td style="width:30%"><?php echo $modPasien->nama_pasien; ?></td>
                <td style="width:20%">UMUR</td>
                <td style="width:30%"><?php echo CustomFunction::hitungUmur($modPasien->tanggal_lahir); ?></td>
            </tr>
            <tr>
                <td style="width:20%">Tgl. Periksa</td>
                <td style="width:20%"><?php echo MyFormatter::formatDateTimeId($modPemeriksaanFisik->tglperiksafisik); ?></td>
                <td style="width:20%">Ruangan</td>
                <td style="width:20%"><?php echo $modPendaftaran->ruangan->ruangan_nama; ?></td>
            </tr>
        </table>
    </div>
    <div >
        <table width="100%" class="content" style="border: none;">
            <tr>
                <td align="center" valign="middle" colspan="4" style="font-weight:bold"><b>
                        <div class="judulcontent"> PERIKSA FISIK</div>
                    </b></td>
            </tr>
            <tr>
                <td>Glasgow Coma Scale</td>
                <td colspan="3">
                    <table width="100%" id="tblDaftarAnamnesa" class="content" border="2">
                        <?php
                        $gcs_eye = RJMetodeGCSM::model()->findByAttributes(array(
                            'metodegcs_nilai' => $modPemeriksaanFisik->gcs_eye,
                            'metodegcs_aktif' => true,
                        ), array(
                            'condition' => "LOWER(metodegcs_singkatan) = 'e'",
                        ));
                        $gcs_verbal = RJMetodeGCSM::model()->findByAttributes(array(
                            'metodegcs_nilai' => $modPemeriksaanFisik->gcs_verbal,
                            'metodegcs_aktif' => true,
                        ), array(
                            'condition' => "LOWER(metodegcs_singkatan) = 'v'",
                        ));
                        $gcs_motorik = RJMetodeGCSM::model()->findByAttributes(array(
                            'metodegcs_nilai' => $modPemeriksaanFisik->gcs_motorik,
                            'metodegcs_aktif' => true,
                        ), array(
                            'condition' => "LOWER(metodegcs_singkatan) = 'm'",
                        ));
                        $hasil = (empty($modPemeriksaanFisik->gcs_eye) ? 0 : $modPemeriksaanFisik->gcs_eye)
                            + (empty($modPemeriksaanFisik->gcs_verbal) ? 0 : $modPemeriksaanFisik->gcs_verbal)
                            + (empty($modPemeriksaanFisik->gcs_motorik) ? 0 : $modPemeriksaanFisik->gcs_motorik);
                        ?>
                        <tr>
                            <td colspan="2" width="30%">GCS Mata (Eye)</td>
                            <td colspan="2" width="70%"><?php echo !empty($gcs_eye) ? $gcs_eye->textMetodeGCSM : " - "; ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" width="30%">GCS Verbal</td>
                            <td colspan="2" width="70%"><?php echo !empty($gcs_verbal) ? $gcs_verbal->textMetodeGCSM : " - "; ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" width="30%">GCS Motorik</td>
                            <td colspan="2" width="70%"><?php echo !empty($gcs_motorik) ? $gcs_motorik->textMetodeGCSM : " - "; ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" width="30%">Hasil</td>
                            <td colspan="2" width="70%"><?php echo isset($hasil) ? $hasil : " - "; ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>Tanda Vital</td>
                <td colspan="3">
                    <table width="100%" id="tekanandarah" class="content" border="2">                                    
                        <tr>
                            <td colspan="2" width="30%">Tekanan Darah</td>
                            <td colspan="2" width="70%"><?php echo $modPemeriksaanFisik->tekanandarah; ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">Mean Arteri Pressure</td>
                            <td colspan="2" ><?php echo $modPemeriksaanFisik->meanarteripressure; ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">Detak Nadi</td>
                            <td colspan="2" ><?php echo $modPemeriksaanFisik->detaknadi; ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">Denyut Jantung</td>
                            <td colspan="2" ><?php echo $modPemeriksaanFisik->denyutjantung; ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">Pernapasan</td>
                            <td colspan="2" ><?php echo $modPemeriksaanFisik->pernapasan; ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">Suhu Tubuh</td>
                            <td colspan="2" ><?php echo $modPemeriksaanFisik->suhutubuh; ?></td>
                        </tr>                                   
                        <tr>
                            <td colspan="2">Tinggi badan / Berat badan</td>
                            <td colspan="2" ><?php echo (isset($modPemeriksaanFisik->tinggibadan_cm) ? $modPemeriksaanFisik->tinggibadan_cm : " - ") . ' Cm / ' . (isset($modPemeriksaanFisik->beratbadan_kg) ? $modPemeriksaanFisik->beratbadan_kg : " - ") . ' Kg'; ?></td>
                        </tr>
                        <?php
                            $bmi_definisi = "-";
                            $bmi = "-";
                            if (!empty($modPemeriksaanFisik->tinggibadan_cm) && !empty($modPemeriksaanFisik->beratbadan_kg) && is_numeric($modPemeriksaanFisik->tinggibadan_cm) && is_numeric($modPemeriksaanFisik->beratbadan_kg) && $modPemeriksaanFisik->tinggibadan_cm != 0) {
                                $bmi = floor($modPemeriksaanFisik->beratbadan_kg / ($modPemeriksaanFisik->tinggibadan_cm * $modPemeriksaanFisik->tinggibadan_cm / 10000));

                                $criteria2 = new CDbCriteria();
                                $criteria2->select = 'max(bmi_minimum) as max_bmi';
                                $modBMI = BodymassindexM::model()->find($criteria2);
                                $criteria = new CDbCriteria();
                                $criteria->addCondition($bmi . ' >= bmi_minimum');
                                $criteria->addCondition($bmi . ' <= bmi_maksimum');
                                $data = array();
                                $bmi_hasil = BodymassindexM::model()->find($criteria);

                                $bmi_definisi = (!empty($bmi_hasil->bmi_defenisi) ? $bmi_hasil->bmi_defenisi : "");
                            }

                            ?>
                            <tr>
                                <td colspan="2">Index Masa Tubuh</td>
                                <td colspan="2" ><?php echo $bmi . " - " . $bmi_definisi; ?></td>
                            </tr>
                            <tr>
                                <td colspan="2">Kelainan Pada Bagian Tubuh</td>
                                <td colspan="2" ><?php echo $modPemeriksaanFisik->kelainanpadabagtubuh; ?></td>
                            </tr>
                            <tr>
                                <td colspan="2">Reflek Cahaya</td>
                                <td colspan="2" ><?php echo $modPemeriksaanFisik->tandavital_reflekcahaya; ?></td>
                            </tr>
                            <tr>
                                <td colspan="2">SPO2</td>
                                <td colspan="2" ><?php echo $modPemeriksaanFisik->tandavital_spo2; ?></td>
                            </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td width="30%">Tekanan Darah</td>
                <td width="20%"><?php echo (isset($modPemeriksaanFisik->tekanandarah) ? $modPemeriksaanFisik->tekanandarah : " - ") . ' /MmHg'; ?></td>
                <td width="30%">Mean Arterial Pressure</td>
                <td width="20%"><?php echo isset($modPemeriksaanFisik->meanarteripressure) ? $modPemeriksaanFisik->meanarteripressure : " - "; ?></td>
            </tr>
            <tr>
                <td width="30%">Detak Nadi</td>
                <td width="20%"><?php echo (isset($modPemeriksaanFisik->detaknadi) ? $modPemeriksaanFisik->detaknadi : " - ") . ' /Menit'; ?></td>
                <td width="30%">Denyut Jantung</td>
                <td width="20%"><?php echo (isset($modPemeriksaanFisik->denyutjantung) ? $modPemeriksaanFisik->denyutjantung : " - "); ?></td>
            </tr>
            <tr>
                <td width="30%">Pernapasan</td>
                <td width="20%"><?php echo (isset($modPemeriksaanFisik->pernapasan) ? $modPemeriksaanFisik->pernapasan : " - ") . ' /Menit'; ?></td>
                <td width="30%">Suhu Tubuh</td>
                <td width="20%"><?php echo (isset($modPemeriksaanFisik->suhutubuh) ? $modPemeriksaanFisik->suhutubuh : " - ") . ' &deg; Celcius'; ?></td>
            </tr>
            <tr>
            </tr>
            <tr>
                <td width="30%">Tinggi badan / Berat badan</td>
                <td width="20%"><?php echo (isset($modPemeriksaanFisik->tinggibadan_cm) ? $modPemeriksaanFisik->tinggibadan_cm : " - ") . ' Cm / ' . (isset($modPemeriksaanFisik->beratbadan_kg) ? $modPemeriksaanFisik->beratbadan_kg : " - ") . ' Kg'; ?></td>
                <td width="30%">Index Masa Tubuh</td>
                <td width="20%"><?php echo (isset($modPemeriksaanFisik->indexmassatubuh) ? $modPemeriksaanFisik->indexmassatubuh : " - "); ?></td>
            </tr>
            <tr>

            </tr>
            <tr>
                <td width="30%">Kelainan Pada Bagian Tubuh</td>
                <td width="20%"><?php echo isset($modPemeriksaanFisik->kelainanpadabagtubuh) ? $modPemeriksaanFisik->kelainanpadabagtubuh : " - "; ?></td>
                <td width="30%">Inspeksi</td>
                <td width="20%"><?php echo isset($modPemeriksaanFisik->inspeksi) ? $modPemeriksaanFisik->inspeksi : " - "; ?></td>
            </tr>
            <tr>
                <td width="30%">Palpasi</td>
                <td width="20%"><?php echo isset($modPemeriksaanFisik->palpasi) ? $modPemeriksaanFisik->palpasi : " - "; ?></td>
                <td width="30%">Perkusi</td>
                <td width="20%"><?php echo isset($modPemeriksaanFisik->perkusi) ? $modPemeriksaanFisik->perkusi : " - "; ?></td>
            </tr>
            <tr>
                <td width="30%"></td>
                <td width="20%"></td>
                <td width="30%">Bising Jantung</td>
                <td width="20%"><?php echo isset($modPemeriksaanFisik->bisingjantung) ? $modPemeriksaanFisik->bisingjantung : " - "; ?></td>
            </tr>
            <tr>
                <td width="30%"></td>
                <td width="20%"></td>
                <td width="30%">Obgyn</td>
                <td width="20%"><?php echo isset($modPemeriksaanFisik->panel_obgyn) ? $modPemeriksaanFisik->panel_obgyn : " - "; ?></td>
            </tr>
            <tr>
                <td width="30%">Auskultasi</td>
                <td width="20%" colspan="3">
                    <?php // echo isset($modPemeriksaanFisik->auskultasi)?$modPemeriksaanFisik->auskultasi:" - "; 
                    ?>
                    <table class="border">
                        <tr>
                            <td colspan="2"></td>
                            <td>Kanan</td>
                            <td>Kiri</td>
                        </tr>
                        <tr>
                            <td rowspan="3" style="vertical-align:top;">P</td>
                            <td rowspan="3" style="vertical-align:top;">Rh</td>
                            <td><?php echo $modPemeriksaanFisik->au_parurhkanan_1; ?></td>
                            <td><?php echo $modPemeriksaanFisik->au_parurhkiri_1; ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $modPemeriksaanFisik->au_parurhkanan_2; ?></td>
                            <td><?php echo $modPemeriksaanFisik->au_parurhkiri_2; ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $modPemeriksaanFisik->au_parurhkanan_3; ?></td>
                            <td><?php echo $modPemeriksaanFisik->au_parurhkiri_3; ?></td>
                        </tr>

                        <tr>
                            <td colspan="2"></td>
                            <td>Kanan</td>
                            <td>Kiri</td>
                        </tr>
                        <tr>
                            <td rowspan="3" style="vertical-align:top;"></td>
                            <td rowspan="3" style="vertical-align:top;">Wh</td>
                            <td><?php echo $modPemeriksaanFisik->au_paruwhkanan_1; ?></td>
                            <td><?php echo $modPemeriksaanFisik->au_paruwhkiri_1; ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $modPemeriksaanFisik->au_paruwhkanan_2; ?></td>
                            <td><?php echo $modPemeriksaanFisik->au_paruwhkiri_2; ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $modPemeriksaanFisik->au_paruwhkanan_3; ?></td>
                            <td><?php echo $modPemeriksaanFisik->au_paruwhkiri_2; ?></td>
                        </tr>

                        <tr>
                            <td rowspan="4" style="vertical-align:top;">C</td>
                            <td rowspan="4" colspan="2" style="vertical-align:top;">Bunyi Jantung</td>
                            <td>S1 <?php echo $modPemeriksaanFisik->au_cardios1; ?></td>
                        </tr>
                        <tr>
                            <td>S2 <?php echo $modPemeriksaanFisik->au_cardios2; ?></td>
                        </tr>
                        <tr>
                            <td>S3 <?php echo $modPemeriksaanFisik->au_cardios3; ?></td>
                        </tr>
                        <tr>
                            <td>S4 <?php echo $modPemeriksaanFisik->au_cardios4; ?></td>
                        </tr>
                    </table>
                </td>
                
            </tr>
        </table>
    </div>
    <div style="page-break-before:always; page-break-after:always;">
        <table width="100%" class="content" style="border: none;"> 
        <tr>
                <td>Abdomen</td>
                <td colspan="3">

                    <table id="tblDaftarAnamnesa" width="100%" class="border" border="2">
                        <tr>
                            <td width="30%">Inspeksi</td>
                            <td><?php echo !empty($modPemeriksaanFisik->abd_inspeksi) ? $modPemeriksaanFisik->abd_inspeksi : "-"; ?></td>
                        </tr>
                        <tr>
                            <td>Palpasi</td>
                            <td>
                                <?php echo !empty($modPemeriksaanFisik->abd_palpasi) ? $modPemeriksaanFisik->abd_palpasi : "-"; ?>
                                <ul>
                                    <li>Leopold I : <?php echo !empty($modPemeriksaanFisik->leopold_1) ? $modPemeriksaanFisik->leopold_1 : "-"; ?></li>
                                    <li>Leopold II : <?php echo !empty($modPemeriksaanFisik->leopold_2) ? $modPemeriksaanFisik->leopold_2 : "-"; ?></li>
                                    <li>Leopold III : <?php echo !empty($modPemeriksaanFisik->leopold_3) ? $modPemeriksaanFisik->leopold_3 : "-"; ?></li>
                                    <li>Leopold IV : <?php echo !empty($modPemeriksaanFisik->leopold_4) ? $modPemeriksaanFisik->leopold_4 : "-"; ?></li>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td>Perkusi</td>
                            <td><?php echo !empty($modPemeriksaanFisik->abd_perkusi) ? $modPemeriksaanFisik->abd_perkusi : "-"; ?></td>
                        </tr>
                        <tr>
                            <td>Auskultasi</td>
                            <td><?php echo !empty($modPemeriksaanFisik->abd_auskultasi) ? $modPemeriksaanFisik->abd_auskultasi : "-"; ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="border">
                <td colspan="4">
                    <b>Integumen: </b><br>
                    <?php
                    $integumen = IntegumenT::model()->findByAttributes(array(
                        'pemeriksaanfisik_id' => $modPemeriksaanFisik->pemeriksaanfisik_id,
                    ));

                    if (!empty($integumen)) :

                    ?>

                        <table width="100%" class="border" border="2">
                            <tr>
                                <td width="30%">Warna</td>
                                <td><?php echo empty($integumen->warna) ? "-" : $integumen->warna; ?></td>
                            </tr>
                            <tr>
                                <td width="30%">Turgor</td>
                                <td><?php echo empty($integumen->tugor) ? "-" : $integumen->tugor; ?></td>
                            </tr>
                            <tr>
                                <td width="30%">Integritas</td>
                                <td><?php echo empty($integumen->integritas) ? "-" : $integumen->integritas; ?></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div style="font-weight: bold; text-align: center; margin-bottom: 5px;">Skala Norton</div>
                                    <table width="100%" id="tab_norton">
                                        <thead>
                                            <tr>
                                                <th style="border: 1px solid black;">Kategori</th>
                                                <th style="border: 1px solid black;">>4</th>
                                                <th style="border: 1px solid black;">>3</th>
                                                <th style="border: 1px solid black;">>2</th>
                                                <th style="border: 1px solid black;">>1</th>
                                                <th style="border: 1px solid black;">>Skor</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Kondisi Fisik</td>
                                                <td><span class="fa fa<?php echo $integumen->norton_kondisifisik == 4 ? '-check' : '' ?>-square-o"></span> Baik</label></td>
                                                <td><span class="fa fa<?php echo $integumen->norton_kondisifisik == 3 ? '-check' : '' ?>-square-o"></span> Sedang</label></td>
                                                <td><span class="fa fa<?php echo $integumen->norton_kondisifisik == 2 ? '-check' : '' ?>-square-o"></span> Buruk</label></td>
                                                <td><span class="fa fa<?php echo $integumen->norton_kondisifisik == 1 ? '-check' : '' ?>-square-o"></span> Sangat Buruk</label></td>
                                                <td style="text-align: right;"><?php echo $integumen->norton_kondisifisik; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Status Mental</td>
                                                <td><span class="fa fa<?php echo $integumen->norton_statusmental == 4 ? '-check' : '' ?>-square-o"></span> Sadar</label></td>
                                                <td><span class="fa fa<?php echo $integumen->norton_statusmental == 3 ? '-check' : '' ?>-square-o"></span> Apatis</label></td>
                                                <td><span class="fa fa<?php echo $integumen->norton_statusmental == 2 ? '-check' : '' ?>-square-o"></span> Bingung</label></td>
                                                <td><span class="fa fa<?php echo $integumen->norton_statusmental == 1 ? '-check' : '' ?>-square-o"></span> Stupor</label></td>
                                                <td style="text-align: right;"><?php echo $integumen->norton_statusmental; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Aktifitas</td>
                                                <td><span class="fa fa<?php echo $integumen->norton_aktifitas == 4 ? '-check' : '' ?>-square-o"></span> Jalan Sendiri</label></td>
                                                <td><span class="fa fa<?php echo $integumen->norton_aktifitas == 3 ? '-check' : '' ?>-square-o"></span> Jalan dengan Bantuan</label></td>
                                                <td><span class="fa fa<?php echo $integumen->norton_aktifitas == 2 ? '-check' : '' ?>-square-o"></span> Kursi Roda</label></td>
                                                <td><span class="fa fa<?php echo $integumen->norton_aktifitas == 1 ? '-check' : '' ?>-square-o"></span> Ditempat Tidur</label></td>
                                                <td style="text-align: right;"><?php echo $integumen->norton_aktifitas; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Mobilitas</td>
                                                <td><span class="fa fa<?php echo $integumen->norton_mobilitas == 4 ? '-check' : '' ?>-square-o"></span> Bebas Bergerak</td>
                                                <td><span class="fa fa<?php echo $integumen->norton_mobilitas == 3 ? '-check' : '' ?>-square-o"></span> Agak Terbatas</td>
                                                <td><span class="fa fa<?php echo $integumen->norton_mobilitas == 2 ? '-check' : '' ?>-square-o"></span> Sangat Terbatas</td>
                                                <td><span class="fa fa<?php echo $integumen->norton_mobilitas == 1 ? '-check' : '' ?>-square-o"></span> Tidak Mampu Bergerak</td>
                                                <td style="text-align: right;"><?php echo $integumen->norton_mobilitas; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Inkontinesia</td>
                                                <td><span class="fa fa<?php echo $integumen->norton_inkontinesia == 4 ? '-check' : '' ?>-square-o"></span> Kontinen</td>
                                                <td><span class="fa fa<?php echo $integumen->norton_inkontinesia == 3 ? '-check' : '' ?>-square-o"></span> Kadang Inkontinensia Uri</td>
                                                <td><span class="fa fa<?php echo $integumen->norton_inkontinesia == 2 ? '-check' : '' ?>-square-o"></span> Selalu Inkontinensia Uri</td>
                                                <td><span class="fa fa<?php echo $integumen->norton_inkontinesia == 1 ? '-check' : '' ?>-square-o"></span> Inkontinensia Uri & Alfi</td>
                                                <td style="text-align: right;"><?php echo $integumen->norton_inkontinesia; ?></td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="5" style="text-align: right;">Total Skor</td>
                                                <td style="text-align: right;"><?php echo $integumen->norton_totalskor; ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="6">Hasil : <?php

                                                                        if ($integumen->norton_totalskor < 12) {
                                                                            echo "Resiko Tinggi Terjadi Dekubitus";
                                                                        } else if ($integumen->norton_totalskor < 16) {
                                                                            echo "Resiko Sedang (Rentang Terjadi Dekubitus)";
                                                                        } else {
                                                                            echo "Tidak ada Resiko Terjadi Dekubitus";
                                                                        }

                                                                        ?></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td width="30%">Kesimpulan</td>
                                <td><?php echo empty($integumen->kesimpulan) ? "-" : $integumen->kesimpulan; ?></td>
                            </tr>
                        </table>

                    <?php
                    endif;
                    ?>
                </td>
            </tr>
            <tr>
                <td>Tanda Vital Janin</td>
                <td colspan="3">

                </td>
            </tr> 
        </table>
        <table border="1" width="100%">
            <tr>
                <td colspan="8">
                    <p style="margin: 0; text-align: center;"><b>Anatomi Tubuh</b></p>
                </td>
            </tr>
            <?php if (count((array)$modPemeriksaanGambar) > 0) { ?>
                <tr>
                    <td>
                        <p style="margin: 0; text-align: center;"><b>No.</b></p>
                    </td>
                    <td><b>Bagian Tubuh</b></td>
                    <td><b>Look</b></td>
                    <td><b>Feel</b></td>
                    <td><b>Move</b></td>
                    <td><b>Sensory</b></td>
                    <td><b>Motorik</b></td>
                    <td><b>Keterangan</b></td>
                </tr>
                <?php foreach ($modPemeriksaanGambar as $i => $v) { ?>
                    <tr>
                        <td>
                            <p style="margin: 0; text-align: center;"><?= $i + 1; ?></p>
                        </td>
                        <td><?= $v->bagiantubuh->namabagtubuh; ?></td>
                        <td><?= $v->look; ?></td>
                        <td><?= $v->feel; ?></td>
                        <td><?= $v->move; ?></td>
                        <td><?= $v->sensory; ?></td>
                        <td><?= $v->motorik; ?></td>
                        <td><?= $v->keterangan_periksa_gbr; ?></td>
                    </tr>
                <?php } ?>
            <?php } ?>
        </table>
        <?php echo $this->renderPartial('rawatJalan.views.pemeriksaanFisik.detail._ewsPrint', array(
        'model' => $modPemeriksaanFisik
        ), true); ?>
        <table width="100%" border="1" <?php echo $hide ?>>
            <tr>
                <td align="center" valign="middle" colspan="2" style="font-weight:bold"><b>Jalan Nafas</b></td>
                <td align="center" valign="middle" colspan="2" style="font-weight:bold"><b>Pernapasan</b></td>
            </tr>
            <tr>
                <td width="30%">Paten</td>
                <td width="20%"><?php echo ($modPemeriksaanFisik->jn_paten) ? '<b>&#8730</b>' : ' - '; ?></td>
                <td width="30%">Simetri</td>
                <td width="20%"><?php echo ($modPemeriksaanFisik->pgd_simetri) ? '<b>&#8730</b>' : ' - '; ?></td>
            </tr>
            <tr>
                <td width="30%">Obstruktif Partial</td>
                <td width="20%"><?php echo ($modPemeriksaanFisik->jn_obstruktifpartial) ? '<b>&#8730</b>' : ' - '; ?></td>
                <td width="30%">Asimetri</td>
                <td width="20%"><?php echo ($modPemeriksaanFisik->pgd_asimetri) ? '<b>&#8730</b>' : ' - '; ?></td>
            </tr>
            <tr>
                <td width="30%">Obstruktif Total</td>
                <td width="20%"><?php echo ($modPemeriksaanFisik->jn_obstruktifnormal) ? '<b>&#8730</b>' : ' - '; ?></td>
                <td width="30%">Normal</td>
                <td width="20%"><?php echo ($modPemeriksaanFisik->pgp_normal) ? '<b>&#8730</b>' : ' - '; ?></td>
            </tr>
            <tr>
                <td width="30%">Stridor</td>
                <td width="20%"><?php echo ($modPemeriksaanFisik->jn_stridor) ? '<b>&#8730</b>' : ' - '; ?></td>
                <td width="30%">Kussmaul</td>
                <td width="20%"><?php echo ($modPemeriksaanFisik->pgp_kussmaul) ? '<b>&#8730</b>' : ' - '; ?></td>
            </tr>
            <tr>
                <td width="30%">Gargling</td>
                <td width="20%"><?php echo ($modPemeriksaanFisik->jn_gargling) ? '<b>&#8730</b>' : ' - '; ?></td>
                <td width="30%">Takipena</td>
                <td width="20%"><?php echo ($modPemeriksaanFisik->pgp_takipnea) ? '<b>&#8730</b>' : ' - '; ?></td>
            </tr>
            <tr>
                <td width="30%"></td>
                <td width="20%"></td>
                <td width="30%">Retraktif</td>
                <td width="20%"><?php echo ($modPemeriksaanFisik->pgp_retraktif) ? '<b>&#8730</b>' : ' - '; ?></td>
            </tr>
            <tr>
                <td width="30%"></td>
                <td width="20%"></td>
                <td width="30%">Dangkal</td>
                <td width="20%"><?php echo ($modPemeriksaanFisik->pgp_dangkal) ? '<b>&#8730</b>' : ' - '; ?></td>
            </tr>
        </table>
    </div>
    <!-- <div style="page-break-before:always; page-break-after:always;">
        
    </div>
    <div style="page-break-before:always; page-break-after:always;">
        
    </div> -->
    <div style="page-break-before:always; page-break-after:always;">
        <table width="100%" border="1" <?php echo $hide ?>>
            <tr>
                <td align="center" valign="middle" colspan="4" style="font-weight:bold"><b>Sirkulasi</b></td>
            </tr>
            <tr>
                <td width="30%">Nadi Carotis</td>
                <td width="20%"><?php echo ($modPemeriksaanFisik->sirkulasi_nadicarotis) ? $modPemeriksaanFisik->sirkulasi_nadicarotis . ' x/menit' : ' - '; ?></td>
                <td width="30%"> Kulit Cyanosis</td>
                <td width="20%"><?php echo ($modPemeriksaanFisik->kulit_cyanosis) ? '<b>&#8730</b>' : ' - '; ?></td>
            </tr>
            <tr>
                <td width="30%">Nadi Radialis</td>
                <td width="20%"><?php echo ($modPemeriksaanFisik->sirkulasi_nadiradialis) ? $modPemeriksaanFisik->sirkulasi_nadiradialis . ' x/menit' : ' - '; ?></td>
                <td width="30%"> Kulit Pucat</td>
                <td width="20%"><?php echo ($modPemeriksaanFisik->kulit_pucat) ? '<b>&#8730</b>' : ' - '; ?></td>
            </tr>
            <tr>
                <td width="30%">CFR</td>
                <td width="20%">
                    <?php echo ($modPemeriksaanFisik->cfr_kecil_2) ? '<b>&#8730</b>' : ' - '; ?> <= 2 &nbsp; &nbsp; <?php echo ($modPemeriksaanFisik->cfr_besar_2) ? '<b>&#8730</b>' : ' - '; ?>>= 2
                </td>
                <td width="30%"> Kulit Berkeringat</td>
                <td width="20%"><?php echo ($modPemeriksaanFisik->kulit_berkeringat) ? '<b>&#8730</b>' : ' - '; ?></td>
            </tr>
            <tr>
                <td width="30%">Kulit Normal</td>
                <td width="20%"><?php echo ($modPemeriksaanFisik->kulit_normal) ? '<b>&#8730</b>' : ' - '; ?></td>
                <td width="30%"> Akral</td>
                <td width="20%"><?php echo ($modPemeriksaanFisik->akral) ? $modPemeriksaanFisik->akral : ' - '; ?></td>
            </tr>
            <tr>
                <td width="30%">Kulit Jaundice</td>
                <td width="20%"><?php echo ($modPemeriksaanFisik->kulit_jaundice) ? '<b>&#8730</b>' : ' - '; ?></td>
                <td width="30%"></td>
                <td width="20%"></td>
            </tr>
        </table>
    </div>
    
    <div style="page-break-before:always; page-break-after:always;">
        <table width="100%" border="1" >
            <tr>
                <td align="center" valign="middle" colspan="4" style="font-weight:bold"><b>Pemeriksaan Mata</b></td>
            </tr>
            <tr>
                <td width="30%"><?= $modPemeriksaanFisik->getAttributeLabel('mata_kanan') ?></td>
                <td width="20%"><?php echo ($modPemeriksaanFisik->mata_kanan) ? $modPemeriksaanFisik->mata_kanan  : ' - '; ?></td>
                <td width="30%"> <?= $modPemeriksaanFisik->getAttributeLabel('warna') ?></td>
                <td width="20%"><?php echo ($modPemeriksaanFisik->warna) ? $modPemeriksaanFisik->warna  : ' - '; ?></td>
            </tr>        
            <tr>
                <td ><?= $modPemeriksaanFisik->getAttributeLabel('mata_kiri') ?></td>
                <td ><?php echo ($modPemeriksaanFisik->mata_kiri) ? $modPemeriksaanFisik->mata_kiri  : ' - '; ?></td>
                <td > <?= $modPemeriksaanFisik->getAttributeLabel('resume') ?></td>
                <td ><?php echo ($modPemeriksaanFisik->resume) ? $modPemeriksaanFisik->resume  : ' - '; ?></td>
            </tr>   
            <tr>
                <td ><?= $modPemeriksaanFisik->getAttributeLabel('segmen_anterior') ?></td>
                <td ><?php echo ($modPemeriksaanFisik->segmen_anterior) ? $modPemeriksaanFisik->segmen_anterior  : ' - '; ?></td>
                <td > </td>
                <td ></td>
            </tr>
            <tr>
                <td ><?= $modPemeriksaanFisik->getAttributeLabel('segmen_posterior') ?></td>
                <td ><?php echo ($modPemeriksaanFisik->segmen_posterior) ? $modPemeriksaanFisik->segmen_posterior  : ' - '; ?></td>
                <td ></td>
                <td ></td>
            </tr>
        </table>
    </div>
    
    <div style="page-break-before:always; page-break-after:always;">
        <?php

        $ruangan = RuanganM::model()->findByPk($modPemeriksaanFisik->create_ruangan);

        if (in_array($ruangan->instalasi_id, array(Params::INSTALASI_ID_REHAB))) : ?>
            <table id="tblDaftarAnamnesa" border="1" width='100%' class='border'>
                <tr>
                    <td colspan='2' width='50%'><b>Kemampuan Fungsional</b></td>
                    <td colspan='2'><b>Pemeriksaan Sistematik Khusus</b></td>
                </tr>
                <tr>
                    <td colspan="2" rowspan='3'>
                        <ul>
                            <?php
                            if ($modPemeriksaanFisik->fungsional_tidur) {
                                echo "<li>";
                                echo $modPemeriksaanFisik->getAttributeLabel('fungsional_tidur');
                                echo "</li>";
                            }
                            if ($modPemeriksaanFisik->fungsional_jalansendiri) {
                                echo "<li>";
                                echo $modPemeriksaanFisik->getAttributeLabel('fungsional_jalansendiri');
                                echo "</li>";
                            }
                            if ($modPemeriksaanFisik->fungsional_alatbantu) {
                                echo "<li>";
                                echo $modPemeriksaanFisik->getAttributeLabel('fungsional_alatbantu');
                                echo empty($modPemeriksaanFisik->fungsional_alatbantu_keterangan) ? "" : " (" . $modPemeriksaanFisik->fungsional_alatbantu_keterangan . ")";
                                echo "</li>";
                            }
                            if ($modPemeriksaanFisik->fungsional_kursiroda) {
                                echo "<li>";
                                echo $modPemeriksaanFisik->getAttributeLabel('fungsional_kursiroda');
                                echo "</li>";
                            }
                            if ($modPemeriksaanFisik->fungsional_prothese) {
                                echo "<li>";
                                echo $modPemeriksaanFisik->getAttributeLabel('fungsional_prothese');
                                echo empty($modPemeriksaanFisik->fungsional_prothese_keterangan) ? "" : " (" . $modPemeriksaanFisik->fungsional_prothese_keterangan . ")";
                                echo "</li>";
                            }
                            if ($modPemeriksaanFisik->fungsional_deformitas) {
                                echo "<li>";
                                echo $modPemeriksaanFisik->getAttributeLabel('fungsional_deformitas');
                                echo empty($modPemeriksaanFisik->fungsional_deformitas_keterangan) ? "" : " (" . $modPemeriksaanFisik->fungsional_deformitas_keterangan . ")";
                                echo "</li>";
                            }
                            if ($modPemeriksaanFisik->fungsional_resikojatuh) {
                                echo "<li>";
                                echo $modPemeriksaanFisik->getAttributeLabel('fungsional_resikojatuh');
                                echo empty($modPemeriksaanFisik->fungsional_resikojatuh_keterangan) ? "" : " (" . $modPemeriksaanFisik->fungsional_resikojatuh_keterangan . ")";
                                echo "</li>";
                            }
                            if ($modPemeriksaanFisik->fungsional_lainlain) {
                                echo "<li>";
                                echo $modPemeriksaanFisik->getAttributeLabel('fungsional_lainlain');
                                echo empty($modPemeriksaanFisik->fungsional_lainlain_keterangan) ? "" : " (" . $modPemeriksaanFisik->fungsional_lainlain_keterangan . ")";
                                echo "</li>";
                            }
                            ?>
                        </ul>
                    </td>
                    <td colspan="2">
                        <b><?php echo $modPemeriksaanFisik->getAttributeLabel('sistematikkhusus_muskuloskeletal') ?></b><br>
                        <?php echo $modPemeriksaanFisik->sistematikkhusus_muskuloskeletal; ?>
                        <br>
                        <br>
                        <b><?php echo $modPemeriksaanFisik->getAttributeLabel('sistematikkhusus_neuromuscular') ?></b><br>
                        <?php echo $modPemeriksaanFisik->sistematikkhusus_neuromuscular; ?>
                        <br>
                        <br>
                        <b><?php echo $modPemeriksaanFisik->getAttributeLabel('sistematikkhusus_cardiopulmunal') ?></b><br>
                        <?php echo $modPemeriksaanFisik->sistematikkhusus_cardiopulmunal; ?>
                        <br>
                        <br>
                        <b><?php echo $modPemeriksaanFisik->getAttributeLabel('sistematikkhusus_integumen') ?></b><br>
                        <?php echo $modPemeriksaanFisik->sistematikkhusus_integumen; ?>
                        <br>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td colspan='2'><b>Pengukuran Khusus</b></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <b><?php echo $modPemeriksaanFisik->getAttributeLabel('pengukurankhusus_muskuloskeletal') ?></b><br>
                        <?php echo $modPemeriksaanFisik->pengukurankhusus_muskuloskeletal; ?>
                        <br>
                        <br>
                        <b><?php echo $modPemeriksaanFisik->getAttributeLabel('pengukurankhusus_neuromuscular') ?></b><br>
                        <?php echo $modPemeriksaanFisik->pengukurankhusus_neuromuscular; ?>
                        <br>
                        <br>
                        <b><?php echo $modPemeriksaanFisik->getAttributeLabel('pengukurankhusus_cardiopulmunal') ?></b><br>
                        <?php echo $modPemeriksaanFisik->pengukurankhusus_cardiopulmunal; ?>
                        <br>
                        <br>
                        <b><?php echo $modPemeriksaanFisik->getAttributeLabel('pengukurankhusus_integumen') ?></b><br>
                        <?php echo $modPemeriksaanFisik->pengukurankhusus_integumen; ?>
                        <br>
                        <br>
                    </td>

                </tr>
            </table>
        <?php endif; ?>
        <table id="tblDaftarAnamnesa" border="1" width="100%">
            <tr>
                <td colspan="2"><b>Data Asesmen Nyeri</b></td>
            </tr>
            <tr>
                <td width="15%">Apakah ada nyeri</td>
                <td><?php
                    echo $modPemeriksaanFisik->keluhan_nyeri ? "Ada, " . $modPemeriksaanFisik->skala_wongbaker_nrs : "Tidak"; ?></td>
            </tr>
            <?php if ($modPemeriksaanFisik->keluhan_nyeri) : ?>
                <tr>
                    <td colspan="2">
                        <?php echo $this->renderPartial($this->path_view . 'pemeriksaan/rehab/_formNyeriDetail', array(
                            'modFisik' => $modPemeriksaanFisik,
                            //'modAsesTriase'=>$modAsesTriase,
                            'modFlaCcs' => $modFlaCcs,
                            'dataFlaCcs' => $dataFlaCcs,
                            'getFlaCcs' => $getFlaCcs
                        ), true); ?>
                    </td>
                </tr>
            <?php endif; ?>
        </table>
        <table style="width: 100%; border: none;">
            <tr>
                <td colspan="9">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="3" align="center" valign="middle">Pasien / Keluarga pasien</td>
                <td colspan="3"></td>
                <td colspan="3" align="center" valign="middle"><?php echo Yii::app()->user->getState('kabupaten_nama') . ", " . MyFormatter::formatDateTimeId(date('Y-m-d', strtotime($modPemeriksaanFisik->tglperiksafisik))); ?><br>Dokter Pemeriksa</td>
            </tr>
            <tr>
                <td colspan="9">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="9">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="9">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="3" align="center" valign="middle"></td>
                <td colspan="3"></td>
                <td colspan="3" align="center" valign="middle"><?php echo (isset($modPendaftaran->pegawai->gelardepan) ? $modPendaftaran->pegawai->gelardepan : '') . ' ' . $modPendaftaran->pegawai->nama_pegawai . ' ' . (isset($modPendaftaran->pegawai->gelarbelakang_nama) ? $modPendaftaran->pegawai->gelarbelakang_nama : ''); ?></td>
            </tr>
        </table>
    </div>
    
        
    
    <div class="footer">
        <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
    </div>
    </div>
    <!-- <div style="page-break-before:always; page-break-after:always;">
       
    </div> -->
    <div style="page-break-before:always; page-break-after:always;">
       
    </div>
<script>
    function titikSesudahSimpan(titikX, titikY, urutan) {
        var titikX = titikX - 15;
        var titikY = titikY - 15;
        var nomor = urutan + 1;
        var color = '#000000';
        var size = '5px';
        $("#imgtag").append(
            $('<div><b>' + nomor + '</b></div>')
            .css('position', 'absolute')
            .css('top', titikY + 'px')
            .css('left', titikX + 'px')
            .css('width', size)
            .css('height', size)
            .css('background-color', color)
            .css('cursor', 'pointer')
            .css('display', 'block')
            .css('padding', '10px')
            .css('-webkit-border-radius', '50%')
            .css('-moz-border-radius', '50%')
            .css('border-radius', '50%')
            .css('vertical-align', 'middle')
            .css('color', '#FFF')
        );
    }

    function loadTitikSesudahSimpan() {
        <?php
        if (!empty($modPemeriksaanGambar)) {
            foreach ($modPemeriksaanGambar as $i => $v) {
        ?>
                titikSesudahSimpan(<?= $v->kordinat_tubuh_x; ?>, <?= $v->kordinat_tubuh_y . ',' . $i; ?>);
        <?php
            }
        }
        ?>
    }
    $(document).ready(function() {
        loadTitikSesudahSimpan();
    });
</script>