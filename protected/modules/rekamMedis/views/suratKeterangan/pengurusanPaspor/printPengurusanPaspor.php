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
        $diagnosa = "<u><b>".$modPasienmorbiditas->diagnosa->diagnosa_nama."</u></b>";
    }else{
        $diagnosa = " _________________ ";
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
                    <B><span FACE="Liberation Serif" SIZE=4><U><?php echo "SURAT KETERANGAN PENGURUSAN PASPOR"; ?></U></span></B>
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
        <table width="100%" style="width:500px;margin-left:80px;">
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
            <tr>
                <td>Tgl. Opname</td>
                <td>:</td>
                <td><?php echo (!empty($modAdmisi->tgladmisi) ? $format->formatDateTimeForUser($modAdmisi->tgladmisi) : '-') ?></td>
            </tr>
        </table><br>
        <p align="justify">
            Berdasarkan hasil pemeriksaan medis maupun penunjang medis terhadap pasien tersebut di atas, dapat disimpulkan pasien tersebut didiagnosa <?php echo (!empty($_GET["pendaftaran_id"]) ? $diagnosa : " _________________ " ) ; ?> 
            <br>dan pengobatan lanjutan ke luar negeri <?php echo "<u>".$model->tujuan_negara."</u>"; ?>.
            <br><br>            
        </p>
        <p align="justify">
            Demikianlah Surat Keterangan Pengurusan Paspor ini diperbuat untuk dapat dipergunakan untuk pengurusan paspor, atas kerjasamanya diucapkan Terima Kasih.
        </p>
</div><br><br><br><br><br>
<div style="margin-left:400px;text-align:center;">
    <?php $date = date('Y-m-d'); ?>
    <?php echo $data->kecamatan->kecamatan_nama ;?>, <?php echo $format->formatDateTimeForUser($date); ?>
<br><br><br><br><br>
    <?php echo (!empty($model->mengetahui_surat) ? "<u><b>".$model->mengetahui_surat."</b></u>" : " _________________ " ) ; ?>
</div>
</TABLE>