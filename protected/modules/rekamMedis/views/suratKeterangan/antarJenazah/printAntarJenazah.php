<?php 
if(isset($_POST["EXCEL"]))
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'."Surat Jalan".'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
} 
$data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
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
                    <B><span FACE="Liberation Serif" SIZE=4><U><?php echo "SURAT JALAN AMBULANCE ANTAR JENAZAH"; ?></U></span></B>
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
        Saya yang bertanda tangan dibawah ini, Direktur <?php echo $data->nama_rumahsakit;?>, dengan ini menerangkan bahwa:
    </p>
    <p align="justify">
        <table width="50%" style="margin-left:100px;width:auto;">
            <tr>
                <td>Nama Pengemudi</td>
                <td>:</td>
                <td><?php 
                $supir = PegawaiM::model()->findByPk($model->supirambulans_id);
                echo empty($supir)?"-":$supir->nama_pegawai; ?></td>
            </tr>
            <tr>
                <td style="padding-right: 55px;">No. SIM</td>
                <td>:</td>
                <td><?php echo (!empty($model->keterangan) ? $model->keterangan : "-"); ?></td>
            </tr>
            <tr>
                <td style="padding-right: 55px;">Nomor Plat Polisi</td>
                <td>:</td>
                <td><?php echo (!empty($model->mobilambulans_id) ? $model->mobil->nopolisi : "-"); ?></td>
            </tr>
        </table>
        <p align="justify">
            untuk mengantar jenazah dengan data sebagai berikut :
            <br>
            <table width="60%" style="margin-left:100px;">
                <tr>
                <td>Nama</td>
                <td>:</td>
                <td><?php echo $modPasien->nama_pasien ?></td>
            </tr>
            <tr>
                <td>Umur/Tgl. lahir</td>
                <td>:</td>
                <td><?php echo $modPendaftaran->umur." / ".$modPasien->tanggal_lahir ?></td>
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
                <td>Tempat Tujuan</td>
                <td>:</td>
                <td><?php echo $modPasien->alamat_pasien; ?></td>
            </tr>
            </table><br>
            <p align="justify">
                Demikian surat jalan ini diperbuat, untuk dapat dipergunakan seperlunya.
            </p>
        </p>
<div style="margin-left:400px;text-align:center;">
    <?php $date = date('Y-m-d'); ?>
</br>
Direktur RS,<br><br><br><br><br>
    <?php echo (!empty($model->mengetahui_surat) ? "<u><b>".$model->mengetahui_surat."</b></u>" : " _________________ " ) ; ?>
</div>
</TABLE>