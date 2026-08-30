<?php 
if(isset($_POST["EXCEL"]))
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'."Surat Keterangan".'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
} 
$data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$format = new MyFormatter();

?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<style>
    p{
        text-indent: 70px;
        text-align: justify;
    }
</style>
        <TABLE ALIGN="CENTER">
             <tr>
                <td ALIGN=CENTER VALIGN=MIDDLE>
                    <B><span FACE="Liberation Serif" SIZE=4><U><?php echo "SURAT KETERANGAN PEMERIKSAAN MATA"; ?></U></span></B>
                </td>
            </tr>
             <tr>
                <td ALIGN=CENTER VALIGN=MIDDLE>
                    <B><span FACE="Liberation Serif" SIZE=4>NO : <?php echo $model->nomorsurat; ?></span></B>
                </td>
            </tr>
        </TABLE>
    </br><br>
    <p align="justify">
         Saya yang bertanda tangan dibawah ini, menerangkan bahwa:
    </p>
    <table width="100%" style="margin-left:100px;">
        <tr>
            <td width="30%" style='padding-right: 70px;'>Nama</td>
            <td width="3%">:</td>
            <td><?php echo $modPasien->nama_pasien ?></td>
        </tr>
        <tr>
            <td style='padding-right: 70px;'>No CM</td>
            <td>:</td>
            <td><?php echo $model->keterangan ?></td>
        </tr>
        <tr>
            <td style='padding-right: 70px;'>Umur</td>
            <td>:</td>
            <td><?php echo $modPendaftaran->umur ?></td>
        </tr>
        <tr>
            <td style='padding-right: 70px;'>Pekerjaan</td>
            <td>:</td>
            <td><?php echo !empty($modPasien->pekerjaan)?$modPasien->pekerjaan->pekerjaan_nama:''; ?></td>
        </tr>
        <tr>
            <td style='padding-right: 70px;'>Alamat</td>
            <td>:</td>
            <td><?php echo $modPasien->alamat_pasien; ?></td>
        </tr>
    </table>
    <p>
    Telah dilakukan pemeriksaan pada matanya dengan hasil sebagai berikut :
    </p>
     
    <table width="100%" style="margin-left:100px;">
        <tr>
            <td width="30%" style='padding-right: 70px;'>1. Tajam penglihatan</td>
            <td width="3%">:</td>
            <td></td>
        </tr>
        <tr>
            <td style='padding-right: 70px;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mata Kanan</td>
            <td>:</td>
            <td><?php echo $modFisik->mata_kanan ?></td>
        </tr>
        <tr>
            <td style='padding-right: 70px;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mata Kanan</td>
            <td>:</td>
            <td><?php echo $modFisik->mata_kiri ?></td>
        </tr>
        <tr>
             <td style="padding-right:70px;">2. Segmen Anterior</td>
             <td>:</td>
             <td> <?= $modFisik->segmen_anterior ?></td>
         </tr>
         <tr>
             <td style="padding-right:70px;">3. Segmen Posterior</td>
             <td>:</td>
             <td> <?= $modFisik->segmen_posterior ?></td>
         </tr>
         <tr>
             <td style="padding-right:70px;">4. Penglihatan</td>
             <td></td>
             <td></td>
         </tr>
         <tr>
             <td style="padding-right:70px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mata/Ishihara Test</td>
             <td></td>
             <td> <?= $modFisik->warna ?></td>
         </tr>
         <tr>
             <td style="padding-right:70px;">5. Resume</td>
             <td>:</td>
             <td> <?= $modFisik->resume ?></td>
         </tr>
    </table>
    
<br><br>
<div style="margin-left:400px;text-align: center;">
    <?php $date = date('Y-m-d'); ?>
    <?php echo $data->kecamatan->kecamatan_nama ;?>, <?php echo $format->formatDateTimeForUser($date); ?>
<br><br><br><br><br>
    <?php echo (!empty($model->mengetahui_surat) ? "<u><b>".$model->mengetahui_surat."</b></u>" : " _________________ " ) ; ?>
</div>
