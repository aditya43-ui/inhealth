<?php 
if(isset($_POST["EXCEL"]))
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'."Surat Keterangan".'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
} 
$data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
if(!empty($modPendaftaran->pasienadmisi_id)){
    $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
}
$pendaftaran_id = $modPendaftaran->pendaftaran_id;
$modPasienmorbiditas = PasienmorbiditasT::model()->find('pendaftaran_id = '.$pendaftaran_id.' AND kelompokdiagnosa_id = '.PARAMS::KELOMPOKDIAGNOSA_UTAMA.'');
if(empty($modPasienmorbiditas)){
    $modPasienmorbiditas = PasienmorbiditasT::model()->find('pendaftaran_id = '.$pendaftaran_id.' AND kelompokdiagnosa_id = '.PARAMS::KELOMPOKDIAGNOSA_MASUK.' OR kelompokdiagnosa_id = '.PARAMS::KELOMPOKDIAGNOSA_TAMBAH.'');
}
    if(!empty($modPasienmorbiditas)){
        $diagnosa = $modPasienmorbiditas->diagnosa->diagnosa_nama;
    }else{
        $diagnosa = "-";
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
    
$format = new MyFormatter();
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
                    <B><span FACE="Liberation Serif" SIZE=4><U><?php echo "SURAT KETERANGAN PENYAKIT GAWAT DARURAT"; ?></U></span></B>
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
        <table width="41%" style="margin-left:100px;width:auto;">
            <tr>
                <td style='padding-right: 68px;'>Nama</td>
                <td>:</td>
                <td><?php echo $modPasien->nama_pasien ?></td>
            </tr>
            <tr>
                <td style='padding-right: 68px;'>Umur/Tgl. lahir</td>
                <td>:</td>
                <td><?php echo $modPendaftaran->umur." / ".  MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir); ?></td>
            </tr>
            <tr>
                <td style='padding-right: 68px;'>Jenis Kelamin</td>
                <td>:</td>
                <td><?php echo $modPasien->jeniskelamin; ?></td>
            </tr>
            <tr>
                <td style='padding-right: 68px;'>No. RK</td>
                <td>:</td>
                <td><?php echo $modPasien->no_rekam_medik; ?></td>
            </tr>
            <tr>
                <td style='padding-right: 68px;'>Alamat</td>
                <td>:</td>
                <td><?php echo $modPasien->alamat_pasien; ?></td>
            </tr>
        </table><br>
        <p align="justify">
            Adalah benar sedang dirawat inap/ opname di RS <?php echo $data->nama_rumahsakit;?> mulai tanggal <?php echo (!empty($modAdmisi->tgladmisi) ? $format->formatDateTimeForUser($modAdmisi->tgladmisi) : "_____________"); ?>.
            Berdasarkan hasil pemeriksaan dokter dapat diinformasikan sebagai berikut :
            <br>
            <table width="41%" style="margin-left:100px;width:auto;">
                <tr>
                    <td style='padding-right: 60px;'>Keluhan Utama</td>
                    <td>:</td>
                    <td><?php echo (!empty($keluhan_utama) ? $keluhan_utama : "-"); ?></td>
                </tr>
                <tr>
                    <td style='padding-right: 60px;'>Tekanan Darah</td>
                    <td>:</td>
                    <td><?php echo (!empty($tekanan_darah) ? $tekanan_darah : "-"); ?></td>
                </tr>
                <tr>
                    <td style='padding-right: 60px;'>Tempratur</td>
                    <td>:</td>
                    <td><?php echo (!empty($tempratur) ? $tempratur : "-"); ?></td>
                </tr>
                <tr>
                    <td style='padding-right: 60px;'>Pols</td>
                    <td>:</td>
                    <td><?php echo (!empty($pols) ? $pols : "-"); ?></td>
                </tr>
                <tr>
                    <td style='padding-right: 60px;'>RR</td>
                    <td>:</td>
                    <td><?php echo (!empty($rr) ? $rr : "-"); ?></td>
                </tr>
                <tr>
                    <td style='padding-right: 60px;'>Lab/Radiologi</td>
                    <td>:</td>
                    <td><?php echo '-'; ?></td>
                </tr>
                <tr>
                    <td style='padding-right: 60px;'>Diagnosa</td>
                    <td>:</td>
                    <td><?php echo (!empty($diagnosa) ? $diagnosa : "-"); ?></td>
                </tr>
            </table><br>
            <p align="justify">
                Sehubungan dengan diagnosa tersebut diatas, pasien dikategorikan menderita penyakit yang harus ditindak dengan cepat (Gawat Darurat).
            </p>            
            <br>
            <p align="justify">
                Demikianlah Surat Keterangan Indikasi Rawat Inap ini diperbuat untuk dapat dipergunakan seperlunya, atas kerjasamanya diucapkan Terima Kasih.
            </p>            
        </p>
</div><br><br><br><br><br>
<div style="margin-left:400px;text-align:center;">
    <?php $date = date('Y-m-d'); ?>
    <?php echo $data->kecamatan->kecamatan_nama ;?>, <?php echo $format->formatDateTimeForUser($date); ?>
<br><br><br><br><br>
    <?php echo (!empty($model->mengetahui_surat) ? "<u><b>".$model->mengetahui_surat."</b></u>" : " _________________ " ) ; ?>
</div>
</TABLE>