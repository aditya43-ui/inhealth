<?php 
if(isset($_POST["EXCEL"]))
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'."Surat Keterangan".'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
} 
$data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$format = new MyFormatter();

$pendaftaran_id = $modPendaftaran->pendaftaran_id;
$modPasienmorbiditas = PasienmorbiditasT::model()->find('pendaftaran_id = '.$pendaftaran_id.' AND kelompokdiagnosa_id = '.PARAMS::KELOMPOKDIAGNOSA_UTAMA.'');
if(empty($modPasienmorbiditas)){
    $modPasienmorbiditas = PasienmorbiditasT::model()->find('pendaftaran_id = '.$pendaftaran_id.' AND kelompokdiagnosa_id = '.PARAMS::KELOMPOKDIAGNOSA_MASUK.' OR kelompokdiagnosa_id = '.PARAMS::KELOMPOKDIAGNOSA_TAMBAH.'');
}
if(!empty($modPasienmorbiditas)){
    $diagnosa = $modPasienmorbiditas->diagnosa->diagnosa_nama;
}else{
    $diagnosa = " ";
}

$modPemeriksaan = PemeriksaanfisikT::model()->find('pendaftaran_id = '.$pendaftaran_id.'');
$modAnamnesa = AnamnesaT::model()->find('pendaftaran_id = '.$pendaftaran_id.'');

if(!empty($modAnamnesa)){
    $keluhan_utama = $modAnamnesa->keluhanutama;
}else{
    $keluhan_utama = '';
}

if(!empty($modPemeriksaan)){
    $tekanan_darah = $modPemeriksaan->tekanandarah;
    $tempratur = $modPemeriksaan->suhutubuh;
    $pols = $modPemeriksaan->detaknadi;
    $rr = $modPemeriksaan->pernapasan;
    $tinggi_badan = $modPemeriksaan->tinggibadan_cm;
    $berat_badan = $modPemeriksaan->beratbadan_kg;
    $pemeriksaan_lain = $modPemeriksaan->kelainanpadabagtubuh;
}else{
    $tekanan_darah = '';
    $tempratur = '';
    $pols = '';
    $rr = '';
    $tinggi_badan = '';
    $berat_badan = '';
    $pemeriksaan_lain = '';
}
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<style>
    p{
        text-indent: 50px;
        text-align: justify;
    }
</style>
<TABLE>
    <div>
        <TABLE ALIGN="CENTER">
             <tr>
                <td ALIGN=CENTER VALIGN=MIDDLE>
                    <B><span FACE="Liberation Serif" SIZE=4><U><?php echo "SURAT KETERANGAN BERBADAN SEHAT"; ?></U></span></B>
                </td>
            </tr>
             <tr>
                <td ALIGN=CENTER VALIGN=MIDDLE>
                    <B><span FACE="Liberation Serif" SIZE=4>NO : <?php echo $model->nomorsurat; ?></span></B>
                </td>
            </tr>
        </TABLE>
    </div>
    </br><br><br><br>
    <div>        
    <p align="justify">
        Saya yang bertanda tangan dibawah ini, Dokter <?php echo $data->nama_rumahsakit;?>, dengan ini menerangkan bahwa:
    </p>
    <p align="justify">
        <table width="50%" style="margin-left:100px;">
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td><?php echo $modPasien->nama_pasien ?></td>
            </tr>
            <tr>
                <td>Umur/Tgl. lahir</td>
                <td>:</td>
                <td><?php echo $modPendaftaran->umur." / ".  MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir); ?></td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td><?php echo $modPasien->jeniskelamin; ?></td>
            </tr>
            <tr>
                <td>No. RK</td>
                <td>:</td>
                <td><?php echo $modPasien->no_rekam_medik; ?></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td><?php echo $modPasien->alamat_pasien; ?></td>
            </tr>
        </table><br>
        <p align="justify">
            Berdasarkan hasil pemeriksaan dokter dapat diinformasikan sebagai berikut :
            <br>
            <table width="41%" style="margin-left:100px;">
                <tr>
                    <td>Tekanan Darah</td>
                    <td>:</td>
                    <td><?php echo (!empty($tekanan_darah) ? $tekanan_darah : "-"); ?></td>
                </tr>
                <tr>
                    <td>Tempratur</td>
                    <td>:</td>
                    <td><?php echo (!empty($tempratur) ? $tempratur : "-"); ?></td>
                </tr>
                <tr>
                    <td>Pols</td>
                    <td>:</td>
                    <td><?php echo (!empty($pols) ? $pols : "-"); ?></td>
                </tr>
                <tr>
                    <td>RR</td>
                    <td>:</td>
                    <td><?php echo (!empty($rr) ? $rr : "-"); ?></td>
                </tr>
                <tr>
                    <td>Tinggi Badan</td>
                    <td>:</td>
                    <td><?php echo (!empty($tinggi_badan) ? $tinggi_badan : "-"); ?></td>
                </tr>
                <tr>
                    <td>Berat Badan</td>
                    <td>:</td>
                    <td><?php echo (!empty($berat_badan) ? $berat_badan : "-"); ?></td>
                </tr>
                <tr>
                    <td>Buta Warna</td>
                    <td>:</td>
                    <td><?php echo (!empty($model->butawarna) ? $model->butawarna : "-"); ?></td>
                </tr>
                <tr>
                    <td>Pemeriksaan Lain</td>
                    <td>:</td>
                    <td><?php echo (!empty($pemeriksaan_lain) ? $pemeriksaan_lain : "-"); ?></td>
                </tr>
            </table><br>
            <p align="justify">
                Sehubungan dengan hasil pemeriksaan di atas dapat disimpulkan bahwa pasien tersebut dinyatakan <?php echo (!empty($model->keterangan) ? "<u><b>".$model->keterangan."</b></u>" : " _________________ " ) ; ?> pada saat pemeriksaan.
            </p><br>
            <p align="justify">
                Demikianlah Surat Keterangan Berbadan Sehat ini diperbuat untuk dapat dipergunakan seperlunya, atas kerjasamanya diucapkan Terima Kasih.
            </p>
        </p>
</div><br><br><br><br><br>
<div style="margin-left:400px;text-align:center;">
    <?php $date = date('Y-m-d'); ?>
    <?php echo $data->kabupaten->kabupaten_nama ;?>, <?php echo $format->formatDateTimeForUser($date); ?>
<br><br><br><br><br>
    <?php echo (!empty($model->mengetahui_surat) ? "<u><b>".$model->mengetahui_surat."</b></u>" : " _________________ " ) ; ?>
</div>
</TABLE>