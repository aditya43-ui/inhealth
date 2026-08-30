<?php $data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
<style>
    .table th, .table td{
        line-height: 5px;
    }
    td, div{
        font-size: 12pt;
    }
    </style>

<?php
	$format = new MyFormatter();
    if (!isset($_GET['frame'])){
    echo $this->renderPartial('_headerPrint'); 
}
?>

<table width="80%">
    <tr>
        <td align="center" valig="middle" colspan="3">
            <table frame=void align=left cellspacing=0 cols=11 rules=none border=0 width="100%">
                <tbody>
                    <tr>
                        <td colspan="3" align="center" style="font-size:14pt;text-decoration:underline;padding:10px;">
                            <b>KUITANSI PEMBAYARAN RETUR RESEP</b>
                        </td>
                    </tr>                    
                    <tr>
                        <td width="20%">No.Kuitansi</td>
                        <td width="2%">:</td>
                        <td align="left"><?php echo (isset($model->tandabuktikeluar->nokaskeluar) ? $model->tandabuktikeluar->nokaskeluar : "") ;?></td>
                    </tr>
                    <tr>
                        <td>Sudah Terima Dari</td>
                        <td>:</td>
                        <td><?php echo (isset($model->tandabuktikeluar->namapenerima) ? $model->tandabuktikeluar->namapenerima : ""); ?></td>
                    </tr>
                    <tr>
                        <td>Banyak Uang</td>
                        <td>:</td>
                        <td><?php echo $format->formatNumberTerbilang($model->tandabuktikeluar->jmlkaskeluar);?></td>
                    </tr>
                    <tr>
                        <td>Untuk Pembayaran</td>
                        <td>:</td>
                        <td><?php echo $model->tandabuktikeluar->untukpembayaran;?> Tanggal <?php echo date('d/m/Y');?></td>
                    </tr>
                    <tr>
                        <td>Nama Pasien</td>
                        <td>:</td>
                        <td><?php echo (isset($model->returresep->pasien->nama_pasien) ? $model->returresep->pasien->nama_pasien : ""); ?> - No. RM : <?php echo (isset($model->returresep->pasien->no_rekam_medik) ? $model->returresep->pasien->no_rekam_medik : "-"); ?></td>
                    </tr>
                </tbody>
            </table>
            <table frame=void align=left cellspacing=0 cols=11 rules=none border=0 width="100%" style="margin: 30px;">
                <tbody>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="50%" align="center">
                            <div style="border:1px solid #000000;margin-left:-220px;width:200px;padding:10px;font-size:14pt;font-weight: bold;">
                                Rp <?php echo number_format($model->tandabuktikeluar->jmlkaskeluar,0,'','.');?>,-  
                            </div>
                        </td>
                        <td align="center">
                                <div><?php echo Yii::app()->user->getState("kabupaten_nama").", " ?><?php echo MyFormatter::formatDateTimeForUser($model->tandabuktikeluar->tglkaskeluar);?></div>
                                <div>Petugas</div>
                                <div>&nbsp;</div>
                                <div>&nbsp;</div>
                                <div>&nbsp;</div>
                                <div>&nbsp;</div>
                                
                                <div>
                                    <?php $pegawai = LoginpemakaiK::pegawaiLoginPemakai(); ?>
                                    <b><?php echo empty($pegawai) ? "-" : $pegawai->nama_pegawai; ?></b>
                                </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div style="font-size:10pt;">Catatan : untuk pembayaran melalui Cheque/Bilyet Giro (BG)<br>
                            belum dianggap lunas apabila Cheque/Bilyet Giro (BG) belum diuangkan<br>
                            <i>*Kuitansi ini sah bila ada tandatangan petugas dan cap <?php echo $data->nama_rumahsakit; ?>*</i></div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>
</table>