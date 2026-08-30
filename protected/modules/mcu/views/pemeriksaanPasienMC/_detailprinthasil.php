<?php

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
// if (isset($caraPrint)) {
//     if ($caraPrint == 'EXCEL') {
//         header('Content-Type: application/vnd.ms-excel');
//         header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
//         header('Cache-Control: max-age=0');
//     }
// echo $this->renderPartial('application.views.headerReport.headerDefault', array('judulLaporan' => $judulLaporan));
// }

$judulLaporanMCU = "MEDICAL CHECK UP";
echo $this->renderPartial('application.views.headerReport.headerDefault1LogoRSKiri', array('judulLaporan' => $judulLaporanMCU, 'colspan' => 3));
?>
<style>
    .barcode-label {
        margin-top: -20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }

    td,
    th {
        font-size: 8pt !important;
        height: 24px;
        padding-left: 10px;
    }
    .footer{
        margin-top: 400px;
    }

    /* body{
        width: 14.7cm;
    } */
    .content td {
        height: 28px;
    }

    .content .sub {
        font-weight: bold;
    }
</style>
<table width="100%">
    <tbody>
    <tr>
        <td align="center" width="42.5%">
        </td>
        <td align="center" width="5%">
            <div style="width: 0px; height: 400px; border: 1px #000 solid;">
            </div>
        </td>
        <td align="center" width="5%">
            <div style="width: 0px; height: 500px; border: 1px #000 solid;">
            </div>
        </td>
        <td align="center" width="5%">
            <div style="width: 0px; height: 400px; border: 1px #000 solid;">
            </div>
        </td>
        <td align="center" width="42.5%">
        </td>
    </tr>
</table>
                    <br/><br/><br/>
<table>
    <tr>
    <td>NO. RM</td><td>:</td><td> <?php echo $modPasien->no_rekam_medik;//?$modKunjungan2->no_rekam_medik:''; ?></td>
    </tr>
    <tr>
<td>Nama Lengkap</td><td>:</td><td> <?php echo $modPasien->nama_pasien;//?$modKunjungan2->namadepan." ".$modKunjungan2->nama_pasien:''; ?></td>
    </tr>
    <tr>
<td>Umur</td><td>:</td><td> <?php echo $modPendaftaran->umur; ?></td>
    </tr>
    <tr>
<td>Perusahaan</td><td>:</td><td> <?php 
if(!empty($modPendaftaran->namaperusahaan)){
echo $modPendaftaran->namaperusahaan;
}else{
    echo '-';
}
?></td>
    </tr>
    <tr>
<td>Tanggal Pemeriksaan</td><td>:</td><td> <?php
if(!empty($model->tgl_pemeriksaan)){
echo MyFormatter::formatDateTimeForuser($model->tgl_pemeriksaan);
}
else{
    echo $format->formatDateTimeForUser($modHasilPemeriksaan->tglhasilpemeriksaanlab);
}
 ?></td>
    </tr>
</tbody>
</table>

                    <br/><br/><br/>
<table>
    <tbody>
<?php
$this->renderPartial($this->path_view_mcu . 'printhasil/_pemeriksaanUmum', array(
    'modPendaftaran' => $modPendaftaran,
    'modPasien' => $modPasien,
    'riwayat1' => $riwayat1
));
?>
</tbody>
</table>
<br /><br /><br />
<table>
    <tbody>
<?php
$this->renderPartial($this->path_view_mcu . 'printhasil/_jantung', array(
    'modPendaftaran' => $modPendaftaran,
    'modPasien' => $modPasien,
    'riwayat2' => $riwayat2
));
?>
</tbody>
</table>
<br /><br /><br />
<table>
    <tbody>
<?php
// $this->renderPartial($this->path_view_mcu . 'printhasil/_kandungan', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'riwayat3' => $riwayat3));
?>
<!-- <br/><br/><br/> -->
<?php
// $this->renderPartial($this->path_view_mcu . 'printhasil/_lainLain', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'riwayat4' => $riwayat4));
?>
<!-- <br/><br/><br/> -->
<?php
$this->renderPartial($this->path_view_mcu . 'printhasil/printHasilPemeriksaan', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'format' => $format, 'modKunjungan2' => $modKunjungan2, 'modHasilPemeriksaan' => $modHasilPemeriksaan, 'modDetailHasilPemeriksaans' => $modDetailHasilPemeriksaans, 'data' => $data));
?>
</tbody>
</table>
<br /><br /><br />
<table>
    <tbody>
<?php
// if (!empty($modPasienMasukPenunjang)) {
//     $this->renderPartial($this->path_view_mcu . 'printhasil/_detailhasilrad', array(
//         'modPendaftaran' => $modPendaftaran,
//         'modPasien' => $modPasien,
//         'detailHasil' => $detailHasil,
//         'masukpenunjang' => $modPasienMasukPenunjang,
//         'pemeriksa' => $pemeriksa,
//         'detailHasil' => $detailHasil,
//     ));
// } else {
?>
<!-- Pemeriksaan Radiologi tidak ditemukan -->
<?php
// }
?>
<!-- <br/><br/><br/> -->
<?php
// if (!empty($modPasienMasukPenunjang2)) {
// $this->renderPartial($this->path_view_mcu . 'printhasil/_detailhasilrehab', array(
//     'modPendaftaran' => $modPendaftaran,
//     'modPasien' => $modPasien,
//     'detailHasil2' => $detailHasil2,
//     'masukpenunjang2' => $modPasienMasukPenunjang2,
//     'pemeriksa2' => $pemeriksa2,
// ));
// } else {
?>
<!-- Pemeriksaan Fisioterapi tidak ditemukan -->
<?php
// }
?>
<!-- <br/><br/><br/> -->
<?php
$this->renderPartial($this->path_view_mcu . 'printhasil/_treadmill', array(
    'modPendaftaran2' => $modPendaftaran2,
    'modPasien2' => $modPasien2,
    'modDetail' => $modDetail,
    'modTreadmill' => $modTreadmill,
    'modTreadmillSearch' => $modTreadmillSearch,
));
?>
</tbody>
</table>
<br /><br /><br />
<?php
// $this->renderPartial($this->path_view_mcu . 'printhasil/_hearingtest', array(
//     'modPendaftaran2' => $modPendaftaran2,
//     'modPasien2' => $modPasien2,
//     'modHearingtest' => $modHearingtest,
//     'modHearingtestSearch' => $modHearingtestSearch,
// ));
?>
<!-- <br/><br/><br/> -->
<table>
    <tbody>
<?php
$this->renderPartial($this->path_view_mcu . 'printhasil/_detailhasildiagnosa', array(
    'modPendaftaran' => $modPendaftaran,
    'modPasien' => $modPasien,
    'detailHasildiagnosa' => $detailHasildiagnosa,
));
?>
</tbody>
</table>
<br /><br /><br />
<?php
// $this->renderPartial($this->path_view_mcu . 'printhasil/_kesimpulansaran', array(
//     'modPendaftaran2' => $modPendaftaran2,
//     'modPasien2' => $modPasien2,
//     'modKesimpulanSaran' => $modKesimpulanSaran,
//     'modSuratStudiLuar' => $modSuratStudiLuar,
//     'modKesimpulanSaranSearch' => $modKesimpulanSaranSearch,
// ));
?>
<!-- <br/><br/><br/> -->
<table>
    <tbody>
<?php
$this->renderPartial($this->path_view_mcu . 'printhasil/_jantungkoroner', array(
    'modPendaftaran2' => $modPendaftaran2,
    'modPasien2' => $modPasien2,
    'modJantungKoroner' => $modJantungKoroner,
    'modJantungKoronerSearch' => $modJantungKoronerSearch,
));
?>
</tbody>
</table>
<br /><br /><br />
<table>
    <tbody>
<?php
$this->renderPartial($this->path_view_mcu . 'printhasil/_tesSpirometri', array(
    'modPendaftaran2' => $modPendaftaran2,
    'modPasien2' => $modPasien2,
    'modTesSpirometri' => $modTesSpirometri,
    'modTesSpirometriSearch' => $modTesSpirometriSearch,
));
?>
    </tbody>
</table>
<table width="100%" class="footer">
    <tfoot>
    <?php   //if (isset($caraPrint) && $caraPrint!="PDF"){  ?>
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultRiwayat', array()); ?>
    <?php  //}  ?>
    </tfoot>
</table>
<?php
if (!isset($_GET['caraPrint'])) {
?>
    <div class="form-actions">
        <?php
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
        //     echo CHtml::link(
        //     Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')),
        //     'javascript:void(0);',
        //     array(
        //         'class' => 'btn btn-info',
        //         'onClick' => 'print("PRINT")'
        //     )
        // );
        ?>
    </div>
<?php
    $urlPrint = $this->createUrl('pemeriksaanPasienMC/detailPrintHasil&id=' . $modKunjungan->pendaftaran_id);
    $js = <<< JSCRIPT
function print(caraPrint)
{
window.open("${urlPrint}&caraPrint="+caraPrint,'printwin','location=_new, width=890px');

}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
}
?>