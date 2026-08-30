<?php
if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
        {
             header('Content-Type: application/vnd.ms-excel');
              header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
              header('Cache-Control: max-age=0');     
        }
    echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan));     
}else{
    // echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan));     
}
?>
<table width="60%" border="1">
    <tr>
        <td style="width:15%">Nama Pasien / No. RM</td>
        <td style="width:15%"> <?php echo $modPasien->nama_pasien; ?> / <?php echo $modPasien->no_rekam_medik; ?></td>
        <td style="width:15%">No. Pendaftaran</td>
        <td style="width:15%"> <?php echo $modPendaftaran->no_pendaftaran; ?></td>
    </tr>
</table>
<table width="100%" class="content" style="border: none;">
<?php 
if (count((array)$riwayat4)>0){
foreach ($riwayat4 as $i => $model){
    // var_dump($model->attributes);
?>
    <table width="100%" border="1px" style="margin-bottom: 10px;">
        <tr>
            <td style="border-right-color:#fff; font-weight: bold;" colspan="2">
                <table style="width: 100%; border: none;">
                    <tr>
                        <td>Tgl. Pemeriksaan</td>
                        <td>: <?php echo MyFormatter::formatDateTimeForuser($model->tgl_pemeriksaan); ?></td>
                        <td>Dokter Pemeriksa</td>
                        <td>: <?php echo empty($model->dokterpemeriksa) ? "-" : $model->dokterpemeriksa->namaLengkap; ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table style="width: 100%; border: none;">
                    <tr>
                        <td width="30%">Hasil Pap Smear</td>
                        <td>: <?php echo $model->hasil_pap_smeer; ?></td>
                    </tr>
                    <tr>
                        <td>Pemeriksaan Mamma</td>
                        <td>: <?php echo $model->pemeriksaan_mamma; ?></td>
                    </tr>
                    <tr>
                        <td>Mata</td>
                        <td>: <?php echo ($model->mata_normal ? "Normal, " : "Abnormal, ").$model->mata_keterangan; ?></td>
                    </tr>
                    <tr>
                        <td>Visus Kanan</td>
                        <td>: <?php echo $model->visus_kanan; ?></td>
                    </tr>
                    <tr>
                        <td>Visus Kiri</td>
                        <td>: <?php echo $model->visus_kiri; ?></td>
                    </tr>
                    <tr>
                        <td>Refraksi</td>
                        <td>: <?php echo $model->refraksi; ?></td>
                    </tr>
                    <tr>
                        <td>Tekanan Bola Mata</td>
                        <td>: <?php echo $model->tekanan_bola_mata; ?></td>
                    </tr>
                    <tr>
                        <td>Persepsi Warna</td>
                        <td>: <?php echo $model->persepsi_warna; ?></td>
                    </tr>
                    <tr>
                        <td>Kacamata Lama</td>
                        <td>: <?php echo $model->kecamata_lama; ?></td>
                    </tr>
                    <tr>
                        <td>Key</td>
                        <td>: <?php echo $model->key_lainlain; ?></td>
                    </tr>
                    <tr>
                        <td>THT</td>
                        <td>: <?php echo $model->tht; ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        
    </table>
<?php }
}else{
?>
    <tr>
        <td colspan="6">* Tidak ada Pemeriksaan Umum</td>
    </tr> 
<?php } ?>
</table> 