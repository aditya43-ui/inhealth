<style>
    #imgtag {
        position: relative;
        min-width: 300px;
        min-height: 300px;
        float: none;
        border: 3px solid #FFF;
        cursor: crosshair;
        text-align: center;
    }

    .tab_thorax td {
        border: 1px solid black;
    }

    .tab_thorax {
        border: 1px solid black;
    }

    #tab_norton td,
    #tab_norton th {
        border: 1px solid black;
        padding: 2px;
    }

    #tab_norton th {
        font-weight: bold;
        text-align: center;
    }

    #tab_norton .skor,
    #tab_norton .total_skor {
        text-align: right;
    }
</style>
<table style="width: 100%; border: none;">
    <tr>
        <td>
            <label class='control-label'>Nama Pasien:</label>
            <?php echo CHtml::encode($modPendaftaran->pasien->nama_pasien ?? ""); ?>
        </td>
        <td>
            <label class='control-label'>Tanggal Pendaftaran:</label>
            <?php echo CHtml::encode($modPendaftaran->tgl_pendaftaran ?? ""); ?>
        </td>
    </tr><br>
    <tr>
        <td>
            <label class='control-label'>Jenis Kelamin:</label>
            <?php echo CHtml::encode($modPendaftaran->pasien->jeniskelamin ?? ""); ?>
        </td>
        <td>
            <label class='control-label'>No Pendaftaran:</label>
            <?php echo CHtml::encode($modPendaftaran->no_pendaftaran ?? ""); ?>
        </td>
    </tr><br>
    <tr>
        <td>
            <label class='control-label'>Umur :</label>
            <?php echo CHtml::encode($modPendaftaran->umur ?? ""); ?>
        </td>
        <td>
            <label class='control-label'>Kelas Pelayanan :</label>
            <?php echo CHtml::encode($modPendaftaran->kelaspelayanan->kelaspelayanan_nama ?? ""); ?>
        </td>
    </tr><br>
    <tr>
        <td>
            <label class='control-label'>Cara Bayar / Penjamin:</label>
            <?php echo CHtml::encode($modPendaftaran->carabayar->carabayar_nama ?? ""); ?> / <?php echo CHtml::encode($modPendaftaran->penjamin->penjamin_nama ?? ""); ?>

        </td>
        <td>
            <label class='control-label'>Nama Dokter:</label>
            <?php echo CHtml::encode($modPendaftaran->pegawai->nama_pegawai ?? ""); ?>
        </td>
    </tr>
    <tr>
        <td>  <label class='control-label'>Nama PPDS:</label>
            <?php echo CHtml::encode(isset($modPemeriksaanFisik->ppds->ppds_nama)?$modPemeriksaanFisik->ppds->ppds_nama : ""); ?>
</td>
        <td>
            <label class='control-label'>Nama Perawat:</label>
            <?php echo CHtml::encode($modPemeriksaanFisik->paramedis_nama ?? ""); ?>

        </td>
    </tr>
</table>
<table id="tblDaftarAnamnesa" class="table table-bordered table-condensed" border="2">
    <?php
    $result = isset($modPemeriksaanFisik->gcs_eye)? $modPemeriksaanFisik->gcs_eye : 0;
    $gcs_eye = RJMetodeGCSM::model()->findByAttributes(array(
        'metodegcs_nilai' => $result,
        'metodegcs_aktif' => true,
    ), array(
        'condition' => "LOWER(metodegcs_singkatan) = 'e'",
    ));
    $resultx = isset($modPemeriksaanFisik->gcs_verbal)? $modPemeriksaanFisik->gcs_verbal : 0;
    $gcs_verbal = RJMetodeGCSM::model()->findByAttributes(array(
        'metodegcs_nilai' =>$resultx,
        'metodegcs_aktif' => true,
    ), array(
        'condition' => "LOWER(metodegcs_singkatan) = 'v'",
    ));
    $resultxr = isset($modPemeriksaanFisik->gcs_verbal)? $modPemeriksaanFisik->gcs_verbal : 0;
   
    $gcs_motorik = RJMetodeGCSM::model()->findByAttributes(array(
        'metodegcs_nilai' => $resultxr,
        'metodegcs_aktif' => true,
    ), array(
        'condition' => "LOWER(metodegcs_singkatan) = 'm'",
    ));
    $hasil = (empty($modPemeriksaanFisik->gcs_eye) ? 0 : $modPemeriksaanFisik->gcs_eye)
        + (empty($modPemeriksaanFisik->gcs_verbal) ? 0 : $modPemeriksaanFisik->gcs_verbal)
        + (empty($modPemeriksaanFisik->gcs_motorik) ? 0 : $modPemeriksaanFisik->gcs_motorik);
    ?>
    <tr>
        <td colspan="4"><b>Glasgow Coma Scale</b></td>
    </tr>
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

<table id="tblDaftarAnamnesa" class="table table-bordered table-condensed" border="2">
    <tr>
        <td colspan="4"><b>Tanda Vital</b></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Tekanan Darah</td>
        <td colspan="2" width="70%"><?php echo (isset($modPemeriksaanFisik->tekanandarah) ? $modPemeriksaanFisik->tekanandarah : " - ") . ' /MmHg'; ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Mean Arterial Pressure</td>
        <td colspan="2" width="70%"><?php echo isset($modPemeriksaanFisik->meanarteripressure) ? $modPemeriksaanFisik->meanarteripressure : " - "; ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Detak Nadi</td>
        <td colspan="2" width="70%"><?php echo (isset($modPemeriksaanFisik->detaknadi) ? $modPemeriksaanFisik->detaknadi : " - ") . ' /Menit'; ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Denyut Jantung</td>
        <td colspan="2" width="70%"><?php echo (isset($modPemeriksaanFisik->denyutjantung) ? $modPemeriksaanFisik->denyutjantung : " - "); ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Pernapasan</td>
        <td colspan="2" width="70%"><?php echo (isset($modPemeriksaanFisik->pernapasan) ? $modPemeriksaanFisik->pernapasan : " - ") . ' /Menit'; ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Suhu Tubuh</td>
        <td colspan="2" width="70%"><?php echo (isset($modPemeriksaanFisik->suhutubuh) ? $modPemeriksaanFisik->suhutubuh : " - ") . ' &deg; Celcius'; ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Tinggi badan / Berat badan</td>
        <td colspan="2" width="70%"><?php echo (isset($modPemeriksaanFisik->tinggibadan_cm) ? $modPemeriksaanFisik->tinggibadan_cm : " - ") . ' Cm / ' . (isset($modPemeriksaanFisik->beratbadan_kg) ? $modPemeriksaanFisik->beratbadan_kg : " - ") . ' Kg'; ?></td>
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
        <td colspan="2" width="30%">Index Masa Tubuh</td>
        <td colspan="2" width="70%"><?php echo $bmi . " - " . $bmi_definisi; ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Kelainan Pada Bagian Tubuh</td>
        <td colspan="2" width="70%"><?php echo isset($modPemeriksaanFisik->kelainanpadabagtubuh) ? $modPemeriksaanFisik->kelainanpadabagtubuh : " - "; ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Reflek Cahaya</td>
        <td colspan="2" width="70%"><?php echo (isset($modPemeriksaanFisik->tandavital_reflekcahaya) && $modPemeriksaanFisik->tandavital_reflekcahaya == 1 ) ? "Positif" : "Negatif"; ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">SPO2</td>
        <td colspan="2" width="70%"><?php echo isset($modPemeriksaanFisik->tandavital_spo2) ? $modPemeriksaanFisik->tandavital_spo2 : " - "; ?></td>
    </tr>
</table>

<?php
$results = isset($modPemeriksaanFisik->create_ruangan)?$modPemeriksaanFisik->create_ruangan:0;
$ruangan = RuanganM::model()->findByPk($results);

$resultr = isset($ruangan->instalasi_id)?$ruangan->instalasi_id:0;
if (in_array($resultr, array(Params::INSTALASI_ID_RD, Params::INSTALASI_ID_PERSALINAN))) : ?>

    <?php echo $this->renderPartial('rawatJalan.views.pemeriksaanFisik.pemeriksaan.rd.view._kepalaLeher', array(
        'modPemeriksaanFisik' => $modPemeriksaanFisik
    ), true); ?>

<?php endif; ?>




<table id="tblDaftarAnamnesa" class="table table-bordered table-condensed" border="2">
    <tr>
        <td colspan="2"><b>Thorax</b></td>
    </tr>
    <tr>
        <td width="30%">Inspeksi</td>
        <td width="70%"><?php echo isset($modPemeriksaanFisik->inspeksi) ? $modPemeriksaanFisik->inspeksi : " - "; ?></td>
    </tr>
    <tr>
        <td width="30%">Palpasi</td>
        <td  width="70%"><?php echo isset($modPemeriksaanFisik->palpasi) ? $modPemeriksaanFisik->palpasi : " - "; ?></td>
    </tr>
    <tr>
        <td width="30%">Bising Jantung</td>
        <td width="70%"><?php echo isset($modPemeriksaanFisik->bisingjantung) ? $modPemeriksaanFisik->bisingjantung : " - "; ?></td>
    </tr>
    <tr hidden>
        <td width="30%">Obgyn</td>
        <td width="70%"><?php echo isset($modPemeriksaanFisik->panel_obgyn) ? $modPemeriksaanFisik->panel_obgyn : " - "; ?></td>
    </tr>
    <tr>
        <td width="30%">Auskultasi</td>
        <td>
            <table class="tab_thorax">
                <tr>
                    <td width="50"></td>
                    <td width="60">Kiri</td>
                    <td width="60">Kanan</td>
                </tr>
                <tr>
                    <td rowspan="3">Rh</td>
                    <td><?php
                    $result1 = isset($modPemeriksaanFisik->au_parurhkanan_1)?$modPemeriksaanFisik->au_parurhkanan_1 : "";
                    echo $result1; ?></td>
                    <td><?php
                      $result1 = isset($modPemeriksaanFisik->au_parurhkiri_1)?$modPemeriksaanFisik->au_parurhkiri_1 : "";
                     echo $result1; ?></td>
                </tr>
                <tr>
                    <td><?php
                       $result2 = isset($modPemeriksaanFisik->au_parurhkanan_2)?$modPemeriksaanFisik->au_parurhkanan_2 : "";
               
                     echo $result2; ?></td>
                    <td><?php
                    $result2 = isset($modPemeriksaanFisik->au_parurhkiri_2)?$modPemeriksaanFisik->au_parurhkiri_2 : "";
               
                     echo $result2; ?></td>
                </tr>
                <tr>
                    <td><?php
                      $result3 = isset($modPemeriksaanFisik->au_parurhkanan_3)?$modPemeriksaanFisik->au_parurhkanan_3 : "";
               
                    echo $result3; ?></td>
                    <td><?php
                           $result3 = isset($modPemeriksaanFisik->au_parurhkiri_3)?$modPemeriksaanFisik->au_parurhkiri_3 : "";
               
                     echo $result3; ?></td>
                </tr>
                <tr>
                    <td width="50">&nbsp;</td>
                    <td width="60"></td>
                    <td width="60"></td>
                </tr>
                <tr>
                    <td rowspan="3">Wh</td>
                    <td><?php
                     $result1 = isset($modPemeriksaanFisik->au_paruwhkanan_1)?$modPemeriksaanFisik->au_paruwhkanan_1 : "";
               
                    echo $result1; ?></td>
                    <td><?php
                      $result1 = isset($modPemeriksaanFisik->au_paruwhkiri_1)?$modPemeriksaanFisik->au_paruwhkiri_1 : "";
               
                    echo $result1; ?></td>
                </tr>
                <tr>
                <td><?php
                     $result2 = isset($modPemeriksaanFisik->au_paruwhkanan_2)?$modPemeriksaanFisik->au_paruwhkanan_2 : "";
               
                    echo $result2; ?></td>
                    <td><?php
                      $result2 = isset($modPemeriksaanFisik->au_paruwhkiri_2)?$modPemeriksaanFisik->au_paruwhkiri_2 : "";
               
                    echo $result2; ?></td>
                </tr>
                <tr>
                    <td><?php
                     $result3 = isset($modPemeriksaanFisik->au_paruwhkanan_3)?$modPemeriksaanFisik->au_paruwhkanan_3 : "";
               
                    echo $result3; ?></td>
                    <td><?php
                      $result3 = isset($modPemeriksaanFisik->au_paruwhkiri_3)?$modPemeriksaanFisik->au_paruwhkiri_3 : "";
               
                    echo $result3; ?></td>
                </tr>
            </table>
            <table class="tab_thorax">
                <tr>
                    <td rowspan="4" width="80">Bunyi<br>Jantung</td>
                    <td width="30">S1</td>
                    <td width="60"><?php
                    $cardio1 = isset($modPemeriksaanFisik->au_cardios1)? $modPemeriksaanFisik->au_cardios1 : "";
                    echo $cardio1; ?></td>
                </tr>
                <tr>
                    <td>S2</td>
                    <td><?php 
                    $cardio2 = isset($modPemeriksaanFisik->au_cardios2)? $modPemeriksaanFisik->au_cardios2 : "";
                    echo $cardio2; ?></td>
                </tr>
                <tr>
                    <td>S3</td>
                    <td><?php
                     $cardio3 = isset($modPemeriksaanFisik->au_cardios3)? $modPemeriksaanFisik->au_cardios3 : "";
                  
                    echo $cardio3; ?></td>
                </tr>
                <tr>
                    <td>S4</td>
                    <td><?php
                    $cardio4 = isset($modPemeriksaanFisik->au_cardios4)? $modPemeriksaanFisik->au_cardios4 : "";
                  
                    echo $cardio4; ?></td>
                </tr>
            </table>


        </td>
    </tr>
</table>

<?php
$integumen = IntegumenT::model()->findByAttributes(array(
    'pemeriksaanfisik_id' => $idFisik,
));

if (!empty($integumen)) :

?>

    <table id="tblDaftarAnamnesa" class="table table-bordered table-condensed" border="2">
        <tr>
            <td colspan="2"><b>Integumen</b></td>
        </tr>
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
                <div style="font-weight: bold; text-align: center">Skala Norton</div>
                <table width="100%" id="tab_norton">
                    <thead>
                        <tr>
                            <th>Kategori</th>
                            <th>4</th>
                            <th>3</th>
                            <th>2</th>
                            <th>1</th>
                            <th>Skor</th>
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

<?php

$ruangan1 = isset($ruangan->instalasi_id)? $ruangan->instalasi_id : "";
if (in_array($ruangan1, array(Params::INSTALASI_ID_RD, Params::INSTALASI_ID_PERSALINAN))) : ?>

    <?php echo $this->renderPartial('rawatJalan.views.pemeriksaanFisik.pemeriksaan.rd.view._cardio', array(
        'modPemeriksaanFisik' => $modPemeriksaanFisik
    ), true); ?>
    <?php echo $this->renderPartial('rawatJalan.views.pemeriksaanFisik.pemeriksaan.rd.view._pulmo', array(
        'modPemeriksaanFisik' => $modPemeriksaanFisik
    ), true); ?>
    <?php echo $this->renderPartial('rawatJalan.views.pemeriksaanFisik.pemeriksaan.rd.view._abdomen', array(
        'modPemeriksaanFisik' => $modPemeriksaanFisik
    ), true); ?>
    <?php echo $this->renderPartial('rawatJalan.views.pemeriksaanFisik.pemeriksaan.rd.view._obstetri', array(
        'modPemeriksaanFisik' => $modPemeriksaanFisik
    ), true); ?>



<?php else :

    echo $this->renderPartial('rawatJalan.views.pemeriksaanFisik.pemeriksaan.rd.view._abdomen', array(
        'modPemeriksaanFisik' => $modPemeriksaanFisik
    ), true);


?>
<?php endif; ?>



<table id="tblDaftarAnamnesa" class="table table-bordered table-condensed" border="2">
    <tr>
        <td colspan="4"><b>Tanda Vital Janin</b></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Denyut Jantung Janin</td>
        <td colspan="2" width="70%"><?php echo !empty($modPemeriksaanFisik->denyutjantung_janin) ? $modPemeriksaanFisik->denyutjantung_janin : " - "; ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Tinggi Fundus Uteri</td>
        <td colspan="2" width="70%"><?php echo !empty($modPemeriksaanFisik->tinggifundus_uteri) ? $modPemeriksaanFisik->tinggifundus_uteri : " - "; ?></td>
    </tr>
</table>



<table id="tblDaftarAnamnesa" class="table table-bordered table-condensed" border="2">
    <tr>
    <tr>
        <td width="412">
        <?php
                $i = 1;
                $gbrTubuh = $modGambarTubuh->AllDataGambarAnatomi;
                $css = '';
                foreach ($gbrTubuh as $tbh) {
                    if (strtolower($modPasien->jeniskelamin ?? "") != strtolower($tbh->jeniskelamin ?? "")) {
                        continue;
                    }
                    if ($i == 1) {
                        $css .= " 
								#imgtag" . $tbh->gambartubuh_id . "
								{
										position: relative;
										min-width: 300px;
										min-height: 300px;
										float: none;
										border: 3px solid #FFF;
										cursor: crosshair;
										text-align: center;
										z-index:10 !important;
								}
								#tagit" . $tbh->gambartubuh_id . "
								{
										position: absolute;
										top: 0;
										left: 0;
										width: 300px;
										border: 1px solid #D7C7C7;
										z-index: 10;
								}
								#tagit" . $tbh->gambartubuh_id . " .name
								{
										/*float: left;*/
										background-color: #FFF;
										width: 295px;
										/*height: 92px;*/
										/*padding: 5px;*/
										font-size: 10pt;
										margin:0 auto;
										margin-bottom: 0 auto;
								}
								#tagit" . $tbh->gambartubuh_id . " DIV.text
								{
										margin-bottom: 5px;
								}
								#tagit" . $tbh->gambartubuh_id . " INPUT[type=text]
								{
										margin-bottom: 5px;
								}
								#tagit" . $tbh->gambartubuh_id . " #tagname" . $tbh->gambartubuh_id . "
								{
										width: 110px;
								}";
                ?>
                        
                        <div align="center" id="imgtag<?php echo $tbh->gambartubuh_id ?>">
                            
                            <!-- <img img-no="<?php echo $tbh->gambartubuh_id ?>" alt="<?php echo $tbh->gambartubuh_id ?>" id="myImgId<?php echo $tbh->gambartubuh_id ?>" src="<?php echo Yii::app()->request->baseUrl; ?>/images/anatomi.jpg" class="taggd<?php echo $tbh->gambartubuh_id ?>" style="width:480px;" data-id="<?php echo $tbh->gambartubuh_id ?>" /> -->

                            <img data-id="<?php echo $tbh->gambartubuh_id; ?>" img-no="<?php echo $tbh->gambartubuh_id ?>" id="myImgId<?php echo $tbh->gambartubuh_id ?>" src="<?php echo Params::urlPhotoAnatomiTubuh().$tbh->nama_file_gbr; ?>" class="taggd<?php echo $tbh->gambartubuh_id ?>" style="width:480px;" />
                            <div id="tagbox<?php echo $tbh->gambartubuh_id ?>"></div>
                        </div>
                    <?php
                     } else {

                        $css .= " 
                                #imgtag" . $tbh->gambartubuh_id . "
                                {
                                        position: relative;
                                        min-width: 300px;
                                        min-height: 300px;
                                        float: none;
                                        border: 3px solid #FFF;
                                        cursor: crosshair;
                                        text-align: center;
										z-index:10 !important;
                                }
                                #tagit" . $tbh->gambartubuh_id . "
                                {
                                        position: absolute;
                                        top: 0;
                                        left: 0;
                                        width: 300px;
                                        border: 1px solid #D7C7C7;
                                        z-index: 10;
                                }
                                #tagit" . $tbh->gambartubuh_id . " .name
                                {
                                        /*float: left;*/
                                        background-color: #FFF;
                                        width: 295px;
                                        /*height: 92px;*/
                                        /*padding: 5px;*/
                                        font-size: 10pt;
                                        margin:0 auto;
                                        margin-bottom: 0 auto;
                                }
                                #tagit" . $tbh->gambartubuh_id . " DIV.text
                                {
                                        margin-bottom: 5px;
                                }
                                #tagit" . $tbh->gambartubuh_id . " INPUT[type=text]
                                {
                                        margin-bottom: 5px;
                                }
                                #tagit" . $tbh->gambartubuh_id . " #tagname" . $tbh->gambartubuh_id . "
                                {
                                        width: 110px;
                                }";
                    ?>
                        <!-- <div align="center" id="imgtag<?php //echo $tbh->gambartubuh_id ?>">
                            
                            <img img-no="<?php //echo $tbh->gambartubuh_id ?>" alt="<?php echo $tbh->gambartubuh_id ?>" id="myImgId<?php echo $i ?>" src="<?php echo Yii::app()->request->baseUrl; ?>/images/anatomi.jpg" class="taggd<?php echo $tbh->gambartubuh_id ?>" style="width:480px;" />
                            <div id="tagbox<?php //echo $tbh->gambartubuh_id ?>"></div>
                        </div> -->
                        <div align="center" id="imgtag<?php echo $tbh->gambartubuh_id ?>">
                        
                            <img data-id="<?php echo $tbh->gambartubuh_id; ?>" img-no="<?php echo $tbh->gambartubuh_id ?>" id="myImgId<?php echo $tbh->gambartubuh_id ?>" src="<?php echo Params::urlPhotoAnatomiTubuh().$tbh->nama_file_gbr; ?>" class="taggd<?php echo $tbh->gambartubuh_id ?>" style="width:480px;" />
                            <div id="tagbox<?php echo $tbh->gambartubuh_id ?>"></div>
                        </div>
                <?php
                    }

                    $i++;
                }
            Yii::app()->clientScript->registerCss('anatomi', $css);
?> 
        <td style="vertical-align:top;">
            <table border="1" width="100%">
                <?php

                if (count((array)$modPemeriksaanGambar) > 0) { ?>
                    <tr>
                        <td>
                            <p style="margin: 0; text-align: center;"><b>No.</b></p>
                        </td>
                        <td><b>Bagian Tubuh</b></td>
                        <td><b>Keterangan</b></td>
                    </tr>
                    <?php foreach ($modPemeriksaanGambar as $i => $v) { ?>
                        <tr>
                            <td>
                                <p style="margin: 0; text-align: center;"><?= $i + 1; ?></p>
                            </td>
                            <td><?= $v->bagiantubuh->namabagtubuh; ?></td>
                            <td>
                                <?= $v->keterangan_periksa_gbr; ?><br>
                                <ul>
                                    <li><b>Look : </b><?php echo empty($v->look) ? "-" : $v->look; ?></li>
                                    <li><b>Feel : </b><?php echo empty($v->feel) ? "-" : $v->feel; ?></li>
                                    <li><b>Move : </b><?php echo empty($v->move) ? "-" : $v->move; ?></li>
                                    <li><b>Sensory : </b><?php echo empty($v->sensory) ? "-" : $v->sensory; ?></li>
                                    <li><b>Motorik : </b><?php echo empty($v->motorik) ? "-" : $v->motorik; ?></li>
                                </ul>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>

<?php 

$ruangan1 = isset($ruangan->instalasi_id)? $ruangan->instalasi_id : "";
if (in_array($ruangan1, array(Params::INSTALASI_ID_RD, Params::INSTALASI_ID_PERSALINAN))) : ?>

    <?php echo $this->renderPartial('rawatJalan.views.pemeriksaanFisik.pemeriksaan.rd.view._genitalia', array(
        'modPemeriksaanFisik' => $modPemeriksaanFisik
    ), true); ?>

<?php endif; ?>

<?php echo $this->renderPartial('rawatJalan.views.pemeriksaanFisik.detail._ews', array(
    'model' => $modPemeriksaanFisik
), true); ?>

<?php 


$ruangan1 = isset($ruangan->instalasi_id)? $ruangan->instalasi_id : "";
if (in_array($ruangan1, array(Params::INSTALASI_ID_RD, Params::INSTALASI_ID_PERSALINAN))) : ?>

    <?php echo $this->renderPartial('rawatJalan.views.pemeriksaanFisik.pemeriksaan.rd.view._lainlain', array(
        'modPemeriksaanFisik' => $modPemeriksaanFisik
    ), true); ?>

<?php else : ?>

    <table id="tblDaftarAnamnesa" class="table table-bordered table-condensed" border="2">
        <tr>
            <td align="center" valign="middle" colspan="2" style="font-weight:bold"><b>Jalan Nafas</b></td>
            <td align="center" valign="middle" colspan="2" style="font-weight:bold"><b>Pernapasan</b></td>
        </tr>
        <tr>
            <td width="30%">Paten</td>
            <td width="20%"><?php
          //  $jn_paten = isset($modPemeriksaanFisik->jn_paten)?$modPemeriksaanFisik->jn_paten:"";
            echo isset($modPemeriksaanFisik->jn_paten) ? '<b>&#8730</b>' : ' - '; ?></td>
            <td width="30%">Simetri</td>
            <td width="20%"><?php
            
            echo isset($modPemeriksaanFisik->pgd_simetri) ? '<b>&#8730</b>' : ' - '; ?></td>
        </tr>
        <tr>
            <td width="30%">Obstruktif Partial</td>
            <td width="20%"><?php echo isset($modPemeriksaanFisik->jn_obstruktifpartial) ? '<b>&#8730</b>' : ' - '; ?></td>
            <td width="30%">Asimetri</td>
            <td width="20%"><?php echo isset($modPemeriksaanFisik->pgd_asimetri) ? '<b>&#8730</b>' : ' - '; ?></td>
        </tr>
        <tr>
            <td width="30%">Obstruktif Total</td>
            <td width="20%"><?php echo isset($modPemeriksaanFisik->jn_obstruktifnormal) ? '<b>&#8730</b>' : ' - '; ?></td>
            <td width="30%">Normal</td>
            <td width="20%"><?php echo isset($modPemeriksaanFisik->pgp_normal) ? '<b>&#8730</b>' : ' - '; ?></td>
        </tr>
        <tr>
            <td width="30%">Stridor</td>
            <td width="20%"><?php echo isset($modPemeriksaanFisik->jn_stridor) ? '<b>&#8730</b>' : ' - '; ?></td>
            <td width="30%">Kussmaul</td>
            <td width="20%"><?php echo isset($modPemeriksaanFisik->pgp_kussmaul) ? '<b>&#8730</b>' : ' - '; ?></td>
        </tr>
        <tr>
            <td width="30%">Gargling</td>
            <td width="20%"><?php echo isset($modPemeriksaanFisik->jn_gargling) ? '<b>&#8730</b>' : ' - '; ?></td>
            <td width="30%">Takipena</td>
            <td width="20%"><?php echo isset($modPemeriksaanFisik->pgp_takipnea) ? '<b>&#8730</b>' : ' - '; ?></td>
        </tr>
        <tr>
            <td colspan="2"><b>Pernapasan Gerak Dada</b></td>
            <td width="30%">Retraktif</td>
            <td width="20%"><?php echo isset($modPemeriksaanFisik->pgp_retraktif) ? '<b>&#8730</b>' : ' - '; ?></td>
        </tr>
        <tr>
            <td width="30%">Simetri</td>
            <td width="20%"><?php echo isset($modPemeriksaanFisik->pgd_simetri) ? '<b>&#8730</b>' : ' - '; ?></td>
            <td width="30%">Dangkal</td>
            <td width="20%"><?php echo isset($modPemeriksaanFisik->pgp_dangkal) ? '<b>&#8730</b>' : ' - '; ?></td>
        </tr>
        <tr>
            <td width="30%">Asimetri</td>
            <td width="20%"><?php echo isset($modPemeriksaanFisik->pgd_asimetri) ? '<b>&#8730</b>' : ' - '; ?></td>
            <td width="30%"></td>
            <td width="20%"></td>
        </tr>
    </table>

    <table id="tblDaftarKeteranganMata" class="table table-bordered table-condensed" border="2">
        <tr>
            <td align="center" valign="middle" colspan="4" style="font-weight:bold"><b>Pemeriksaan Mata</b></td>
        </tr>
        <tr>
            <td width="30%"><?= 'Mata Kanan' ?></td>
            <td width="20%"><?php echo isset($modPemeriksaanFisik->mata_kanan) ? $modPemeriksaanFisik->mata_kanan  : ' - '; ?></td>
            <td width="30%"> <?= 'Warna' ?></td>
            <td width="20%"><?php echo isset($modPemeriksaanFisik->warna) ? $modPemeriksaanFisik->warna  : ' - '; ?></td>
        </tr>        
        <tr>
            <td ><?= 'Mata Kiri' ?></td>
            <td ><?php echo isset($modPemeriksaanFisik->mata_kiri) ? $modPemeriksaanFisik->mata_kiri  : ' - '; ?></td>
            <td > <?= 'Resume' ?></td>
            <td ><?php echo isset($modPemeriksaanFisik->resume) ? $modPemeriksaanFisik->resume  : ' - '; ?></td>
        </tr>   
        <tr>
            <td ><?= 'Segmen Anterior' ?></td>
            <td ><?php echo isset($modPemeriksaanFisik->segmen_anterior) ? $modPemeriksaanFisik->segmen_anterior  : ' - '; ?></td>
            <td > </td>
            <td ></td>
        </tr>
        <tr>
            <td ><?= "Segmen Posterior" ?></td>
            <td ><?php echo isset($modPemeriksaanFisik->segmen_posterior) ? $modPemeriksaanFisik->segmen_posterior  : ' - '; ?></td>
            <td ></td>
            <td ></td>
        </tr>
    </table>

    <table id="tblDaftarAnamnesa" class="table table-bordered table-condensed" border="2">
        <tr>
            <td align="center" valign="middle" colspan="4" style="font-weight:bold"><b>Sirkulasi</b></td>
        </tr>
        <tr>
            <td width="30%">Nadi Carotis</td>
            <td width="20%"><?php echo isset($modPemeriksaanFisik->sirkulasi_nadicarotis) ? $modPemeriksaanFisik->sirkulasi_nadicarotis . ' x/menit' : ' - '; ?></td>
            <td width="30%"> Kulit Cyanosis</td>
            <td width="20%"><?php echo isset($modPemeriksaanFisik->kulit_cyanosis) ? '<b>&#8730</b>' : ' - '; ?></td>
        </tr>
        <tr>
            <td width="30%">Nadi Radialis</td>
            <td width="20%"><?php echo isset($modPemeriksaanFisik->sirkulasi_nadiradialis) ? $modPemeriksaanFisik->sirkulasi_nadiradialis . ' x/menit' : ' - '; ?></td>
            <td width="30%"> Kulit Pucat</td>
            <td width="20%"><?php echo isset($modPemeriksaanFisik->kulit_pucat) ? '<b>&#8730</b>' : ' - '; ?></td>
        </tr>
        <tr>
            <td width="30%">CFR</td>
            <td width="20%">
                <?php echo isset($modPemeriksaanFisik->cfr_kecil_2) ? '<b>&#8730</b>' : ' - '; ?> <= 2 &nbsp; &nbsp; <?php echo isset($modPemeriksaanFisik->cfr_besar_2) ? '<b>&#8730</b>' : ' - '; ?>>= 2
            </td>
            <td width="30%"> Kulit Berkeringat</td>
            <td width="20%"><?php echo isset($modPemeriksaanFisik->kulit_berkeringat) ? '<b>&#8730</b>' : ' - '; ?></td>
        </tr>
        <tr>
            <td width="30%">Kulit Normal</td>
            <td width="20%"><?php echo isset($modPemeriksaanFisik->kulit_normal) ? '<b>&#8730</b>' : ' - '; ?></td>
            <td width="30%"> Akral</td>
            <td width="20%"><?php echo isset($modPemeriksaanFisik->akral) ? $modPemeriksaanFisik->akral : ' - '; ?></td>
        </tr>
        <tr>
            <td width="30%">Kulit Jaundice</td>
            <td width="20%"><?php echo isset($modPemeriksaanFisik->kulit_jaundice) ? '<b>&#8730</b>' : ' - '; ?></td>
            <td width="30%"></td>
            <td width="20%"></td>
        </tr>
    </table>
    <table id="tblDaftarAnamnesa" class="table table-bordered table-condensed" border="2">
        <tr>
            <td colspan="2"><b>Kekuatan Otot</b></td>
            <td colspan="2"><b>Lingkup Gerak Sendi</b></td>
        </tr>
        <tr>
            <td width="30%">Cybex</td>
            <td width="20%"><?php echo empty($modPemeriksaanFisik->kekuatanotot_cybex) ? "-" : $modPemeriksaanFisik->kekuatanotot_cybex; ?></td>
            <td width="30%">Iknometer</td>
            <td width="20%"><?php echo empty($modPemeriksaanFisik->lingkupgeraksendi_ikinometer) ? "-" : $modPemeriksaanFisik->lingkupgeraksendi_ikinometer; ?></td>
        </tr>
        <tr>
            <td width="30%">En-Tree</td>
            <td width="20%"><?php echo empty($modPemeriksaanFisik->kekuatanotot_entree) ? "-" : $modPemeriksaanFisik->kekuatanotot_entree; ?></td>
            <td width="30%">Goniometer</td>
            <td width="20%"><?php echo empty($modPemeriksaanFisik->lingkupgeraksendi_goniometer) ? "-" : $modPemeriksaanFisik->lingkupgeraksendi_goniometer; ?></td>
        </tr>
        <tr>
            <td width="30%">Nk-Table</td>
            <td width="20%"><?php echo empty($modPemeriksaanFisik->kekuatanotot_nktable) ? "-" : $modPemeriksaanFisik->kekuatanotot_nktable; ?></td>
            <td width="30%"></td>
            <td width="20%"></td>
        </tr>
        <tr>
            <td width="30%">Hand-Held Dinamometer</td>
            <td width="20%"><?php echo empty($modPemeriksaanFisik->kekuatanotot_handhelddinamo) ? "-" : $modPemeriksaanFisik->kekuatanotot_handhelddinamo; ?></td>
            <td width="30%"></td>
            <td width="20%"></td>
        </tr>
        <tr>
            <td width="30%">Pinchmeter</td>
            <td width="20%"><?php echo empty($modPemeriksaanFisik->kekuatanotot_pinchmeter) ? "-" : $modPemeriksaanFisik->kekuatanotot_pinchmeter; ?></td>
            <td width="30%"></td>
            <td width="20%"></td>
        </tr>
        <tr>
            <td colspan="2"><b>Fleksibilitas</b></td>
            <td colspan="2"><b>Sensibilitas</b></td>
        </tr>
        <?php
        $result = isset($modPemeriksaanFisik->sensibilitas_panasdingin)?   $modPemeriksaanFisik->sensibilitas_panasdingin :"";
        $result2 = isset($modPemeriksaanFisik->sensibilitas_tajamtumpul)?   $modPemeriksaanFisik->sensibilitas_tajamtumpul :"";
        $result3 = isset($modPemeriksaanFisik->sensibilitas_kasarhalus)?   $modPemeriksaanFisik->sensibilitas_kasarhalus :"";
        $result4 = isset($modPemeriksaanFisik->sensibilitas_titik)?   $modPemeriksaanFisik->sensibilitas_titik :"";
       
        $result = explode(":", $result);
        $result2 = explode(":", $result2);
        $result3 = explode(":", $result3);
        $result4 = explode(":", $result4);
        
        
        ?>
        <tr>
            <td width="30%">Schober Test</td>
            <td><?php echo empty($modPemeriksaanFisik->fleksibilitas_schober) ? "-" : $modPemeriksaanFisik->fleksibilitas_schober ?></td>
            <td width="50%" colspan="2" style="text-align: center;"><i class="<?php echo in_array("Panas", $result) ? "entypo-check" : "entypo-cancel" ?>"></i> Panas / Dingin<i class="<?php echo in_array("Dingin", $result) ? "entypo-check" : "entypo-cancel" ?>"></i></td>

        </tr>
        <tr>
            <td>Site And Reach Test</td>
            <td><?php echo empty($modPemeriksaanFisik->fleksibilitas_sitandreach) ? "-" : $modPemeriksaanFisik->fleksibilitas_sitandreach ?></td>
            <td width="50%" colspan="2" style="text-align: center;"><i class="<?php echo in_array("Tajam", $result2) ? "entypo-check" : "entypo-cancel" ?>"></i> Tajam / Tumpul<i class="<?php echo in_array("Tumpul", $result2) ? "entypo-check" : "entypo-cancel" ?>"></i></td>

        </tr>
        <tr>
            <td>Shoulder Fleksibility Test</td>
            <td><?php echo empty($modPemeriksaanFisik->fleksibilitas_shoulderfleksibility) ? "-" : $modPemeriksaanFisik->fleksibilitas_shoulderfleksibility ?></td>
            <td width="50%" colspan="2" style="text-align: center;"><i class="<?php echo in_array("Kasar", $result3) ? "entypo-check" : "entypo-cancel" ?>"></i> Kasar / Halus<i class="<?php echo in_array("Halus", $result3) ? "entypo-check" : "entypo-cancel" ?>"></i></td>

        </tr>
        <tr>
            <td>Tes Sentuh Jari Kaki</td>
            <td><?php echo empty($modPemeriksaanFisik->fleksibilitas_sentuhjarikaki) ? "-" : $modPemeriksaanFisik->fleksibilitas_sentuhjarikaki ?></td>
            <td width="50%" colspan="2" style="text-align: center;"><i class="<?php echo in_array("1 Titik", $result4) ? "entypo-check" : "entypo-cancel" ?>"></i>1 Titik / 2 Titik<i class="<?php echo in_array("2 Titik", $result4) ? "entypo-check" : "entypo-cancel" ?>"></i></td>

        </tr>
        <tr>
            <td colspan="2"><b>Kesimpulan : </b><br><?php echo empty($modPemeriksaanFisik->fleksibilitas_kesimpulan) ? "-" : $modPemeriksaanFisik->fleksibilitas_kesimpulan; ?></td>
            <td colspan="2"><b>Saran : </b><br><?php echo empty($modPemeriksaanFisik->fleksibilitas_saran) ? "-" : $modPemeriksaanFisik->fleksibilitas_saran; ?></td>
        </tr>
    </table>

    <?php 
    $ruanganx= isset($ruangan->instalasi_id) ? $ruangan->instalasi_id : 0;
    if (in_array($ruanganx, array(Params::INSTALASI_ID_REHAB))) : ?>
        <table id="tblDaftarAnamnesa" class="table table-bordered table-condensed" border="2">
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
                            echo "Fungsional Tidur";
                            echo "</li>";
                        }
                        if ($modPemeriksaanFisik->fungsional_jalansendiri) {
                            echo "<li>";
                            echo "Fungsional Jalan Sendiri";
                            echo "</li>";
                        }
                        if ($modPemeriksaanFisik->fungsional_alatbantu) {
                            echo "<li>";
                            echo "Fungsional Alat Bantu";
                            echo empty($modPemeriksaanFisik->fungsional_alatbantu_keterangan) ? "" : " (" . $modPemeriksaanFisik->fungsional_alatbantu_keterangan . ")";
                            echo "</li>";
                        }
                        if ($modPemeriksaanFisik->fungsional_kursiroda) {
                            echo "<li>";
                            echo "Fungsional Kursi Roda";
                            echo "</li>";
                        }
                        if ($modPemeriksaanFisik->fungsional_prothese) {
                            echo "<li>";
                            echo "Fungsional Prothese";
                            echo empty($modPemeriksaanFisik->fungsional_prothese_keterangan) ? "" : " (" . $modPemeriksaanFisik->fungsional_prothese_keterangan . ")";
                            echo "</li>";
                        }
                        if ($modPemeriksaanFisik->fungsional_deformitas) {
                            echo "<li>";
                            echo "Fungsional Deformitas";
                            echo empty($modPemeriksaanFisik->fungsional_deformitas_keterangan) ? "" : " (" . $modPemeriksaanFisik->fungsional_deformitas_keterangan . ")";
                            echo "</li>";
                        }
                        if ($modPemeriksaanFisik->fungsional_resikojatuh) {
                            echo "<li>";
                            echo "Fungsional Resiko Jatuh";
                            echo empty($modPemeriksaanFisik->fungsional_resikojatuh_keterangan) ? "" : " (" . $modPemeriksaanFisik->fungsional_resikojatuh_keterangan . ")";
                            echo "</li>";
                        }
                        if ($modPemeriksaanFisik->fungsional_lainlain) {
                            echo "<li>";
                            echo "Fungsional Lain-lain";
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
        <br>
    <?php endif; ?>

    <table id="tblDaftarAnamnesa" class="table table-bordered table-condensed" border="2">
        <tr>
            <td colspan="2"><b>Data Asesmen Nyeri</b></td>
        </tr>
        <tr>
            <td width="15%">Apakah ada nyeri</td>
            <td><?php
                 // $keluhan = isset($modPemeriksaanFisik->keluhan_nyeri) ? $modPemeriksaanFisik->keluhan_nyeri : "";
                echo isset($modPemeriksaanFisik->keluhan_nyeri) ? "Ada, " . $modPemeriksaanFisik->skala_wongbaker_nrs : "Tidak"; ?></td>
        </tr>
        <?php if (isset($modPemeriksaanFisik->keluhan_nyeri)) : ?>
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
<?php endif; ?>
<table>
    <tr>
        <td><?php echo CHtml::link(Yii::t('mds', '{icon} Print Detail', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printFisik();return false")); ?></td>
    </tr>
</table>

<script type="text/javascript">
    
    function printFisik() {
        window.open('<?php echo $this->createUrl('printPemeriksaanFisik2', array('notriage_pasien_id' => $idFisik,'pemeriksaanfisik_id' => $notriage_pasien_id)); ?>', 'printwin', 'left=100,top=100,width=640,height=480');
    }

    function titikSesudahSimpanDetail(titikX, titikY, urutan) {
        var titikX = $("#imgtag_detail").position().left + titikX - 10;
        var titikY = $("#imgtag_detail").position().top + titikY;
        var nomor = urutan + 1;
        var color = '#000000';
        var size = '5px';
        $("#imgtag_detail").append(
            $('<div class="dot_gambar"><b>' + nomor + '</b></div>')
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

    function loadTitikSesudahSimpanDetail() {
        $("#imgtag_detail .dot_gambar").remove();
        <?php if (!empty($modPemeriksaanGambar)) {
            foreach ($modPemeriksaanGambar as $i => $v) { ?>
                titikSesudahSimpanDetail(<?= $v->kordinat_tubuh_x; ?>, <?= $v->kordinat_tubuh_y . ',' . $i; ?>);
        <?php }
        } ?>
    }

    $("#contentDetailFisik2").on("load_detail_periksagambar", function() {
        loadTitikSesudahSimpanDetail();
    });
</script>