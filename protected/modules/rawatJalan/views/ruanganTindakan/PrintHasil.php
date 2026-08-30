<style type="text/css">
    body {
        /*    width: 10.5cm;*/
    }

    .judulcontent {
        font-weight: bold;
        font-size: 17pt;
        text-align: center;
        text-decoration: underline;
    }

    hr {
        border: none;
        /* Menghapus garis bawaan */
        height: 2px;
        /* Menentukan tinggi garis */
        background-color: black;
        /* Menentukan warna garis */
        margin: 10px 0;
        /* Menentukan margin atas dan bawah */
    }

    .footer {
        text-align: right;
        margin: 10px 10px;
    }
</style>

<?php

if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
}
//echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>10)); 

$style = 'margin-left:auto; margin-right:auto;';
if (isset($caraPrint)) {
    if ($caraPrint == "EXCEL")
        $style = "cellpadding='10',cellspasing='6', width='100%'";
    //            $td = "width='100%'";
} else {
    $style = "style='margin-left:auto; margin-right:auto;'";
    //        $td ='';
}
?>
<?php
$data = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$konfig = KonfigsystemK::model()->find();

// var_dump($profil->logo_rumahsakit_2);die;
?>

<table style="width: 100%; border: none;">
    <tbody> 
        <table border=1 width="100%">
            <tr>
                <td><img src="<?php echo Params::urlProfilRSDirectory() . $data->logo_rumahsakit_2 ?>" style="float:center; max-width: 140px; width:140px;" class='image_report' /></td>
                <td> <?php echo $konfig->alamatheadersurat ?></td>
                <td><img src="<?php echo Params::urlProfilRSDirectory() . $data->logo_rumahsakit ?>" style="float:center; max-width: 100px; width:100px;" class='image_report' /></td>
            </tr>
        </table><br>
        <div class="judulcontent"> <?php echo $judulLaporan  ?> </div>
        <br><br><br>
        <table width="100%">
            <tr>
                <td>
                    <table>
                        <tr>
                            <td>No. Pendaftaran</td>
                            <td> : </td>
                            <td><?= $modPendaftaran->no_pendaftaran ?></td>
                        </tr>
                        <tr>
                            <td>Tanggal Pendaftaran</td>
                            <td> : </td>
                            <td><?= MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran) ?></td>
                        </tr>
                        <tr>
                            <td>Ruangan</td>
                            <td> : </td>
                            <td><?=  $hasilPemeriksaan[0]->ruangan->ruangan_nama ?></td>
                        </tr>
                        <!-- <tr>
                    <td>No. Hasil Pemeriksaan</td>
                    <td> : </td>
                    <td><?php //$modPasienMasukPenunjang->no_masukpenunjang ?? '' 
                        ?></td>
                </tr> -->
                        <tr>
                            <td>Tanggal Pemeriksaan</td>
                            <td> : </td>
                            <td><?= MyFormatter::formatDateTimeForUser($hasilPemeriksaan[0]->tglpemeriksaantindakan) ?></td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Nama Pasien</td>
                            <td> : </td>
                            <td><?= $modPendaftaran->pasien->nama_pasien ?></td>
                        </tr>
                        <tr>
                            <td>Tanggal Lahir</td>
                            <td> : </td>
                            <td><?= MyFormatter::formatDateTimeForUser($modPendaftaran->pasien->tanggal_lahir) ?></td>
                        </tr>
                        <tr>
                            <td>Jenis Kelamin</td>
                            <td> : </td>
                            <td><?= $modPendaftaran->pasien->jeniskelamin ?></td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td> : </td>
                            <td><?= $modPendaftaran->pasien->alamat_pasien ?></td>
                        </tr>
                        <tr>
                            <td>Jenis Penjamin</td>
                            <td> : </td>
                            <td><?= $modPendaftaran->carabayar->carabayar_nama ?></td>
                        </tr>
                    </table>
            </tr>

        </table>
        <hr>
        <div>Hasil Pemeriksaan :</div><br>
        <div><?php echo $hasilPemeriksaan[0]->hasilpemeriksaantindakan ?></div><br><br>
        <div>Kesimpulan :</div><br>
        <div><?php echo $hasilPemeriksaan[0]->kesimpulantindakan ?></div>
    </tbody>
    <tfoot>
        <tr>
            <td>
                <div class="footer-space">&nbsp;</div>
            </td>
        </tr>
    </tfoot>
</table>
<div class="">
</div>
<div class="footer">
<div style="margin-right: 27px;">
<?php
    $jam = explode(' ', $hasilPemeriksaan[0]->tglpemeriksaantindakan);
    echo $data->kabupaten->kabupaten_nama . " , " . MyFormatter::formatDateTimeForUser($jam[0]); ?>
</div>
   
    <div>Dokter Penanggungjawab Pasien(DPJP)</div>
    <?php //echo Yii::app()->user->getState('kabupaten_nama')." , ".date("d M Y"); 
    ?>
    <br /><br /><br /><br /><br />
    <div style="margin-right: 13px">
    <?php
    if (empty($modPasienMasukPenunjang->pegawai->nama_pegawai)) {
        echo "( .............................. )";
    } else {
        echo $modPasienMasukPenunjang->pegawai->nama_pegawai;
    }
    ?>
    </div>
</div>