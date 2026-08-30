<?php $data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); 
$format = new MyFormatter();
?>
<style>
    body {
        letter-spacing: 2px;
    }
    table, td, div{
        font-size: 8pt;
        font-family: Arial;
    }
    .catatan{
        font-size: 8pt;
        text-align: left;
    }
    .uang{
        font-size: 12pt;
        font-weight: bold;
    }
    .terbilang{
        font-style: italic;
    }
    .tandatangan{
        text-align: center;
        vertical-align: top;
    }
</style>

<?php // echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan)); ?>

<table style="width: 100%; border: none;">
<!--<tr>
        <td colspan="3" height="100px">
            <?php // echo $this->renderPartial('application.views.headerReport.headerDefault'); ?>
        </td>
    </tr>-->
    <tr>
        <td colspan="3">
            <?php 
            $ru = "";
            $modPendaftaran = $tandabuktibayar->pembayaranpelayanan->pendaftaran;
            if (!empty($modPendaftaran->pasienadmisi_id)) $ru = " RAWAT INAP";
            else $ru = " ".strtoupper($modPendaftaran->instalasi->instalasi_nama);
            $slippage = "No Kuitansi : ".$model->tandabuktikeluar->nokaskeluar;
            echo $this->renderPartial('application.views.headerReport.headerDefaultKwitansi', array('noKwitansi'=>$slippage)); ?>
        </td>
    </tr>
    <tr>
        <td align="center" valign="middle" colspan="3">
            <table align="center" cellspacing=0 width="100%">
                <tbody>
                    <tr>
                        <td colspan="3" align="center" style="font-size:15pt;text-decoration:underline;padding:10px;">
                            <b>KUITANSI RETUR TAGIHAN PASIEN</b>
                        </td>
                    </tr>        
                    <tr>
                        <td>Sudah Terima Kepada</td>
                        <td>:</td>
                        <td><?php echo (isset($model->tandabuktikeluar->namapenerima) ? $model->tandabuktikeluar->namapenerima : ""); ?></td>
                    </tr>
                    <tr>
                        <td>Uang Sejumlah</td>
                        <td>:</td>
                        <td class="terbilang"><?php echo strtoupper($format->formatNumberTerbilang($model->tandabuktikeluar->jmlkaskeluar));?></td>
                    </tr>
                    <tr>
                        <td>Untuk Pembayaran</td>
                        <td>:</td>
                        <td><?php echo $model->tandabuktikeluar->untukpembayaran;?> Tanggal <?php echo MyFormatter::formatDateTimeForUser(date('d-m-Y'));?></td>
                    </tr>
                </tbody>
            </table>
            <table frame=void align=left cellspacing=0 cols=11 rules=none border=0 width="100%">
                <tbody>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="60%" align="center">
                            <div style="text-align: center;">
                                <br>
                                <div align="center" style="border:1px solid #000000;width:200px;padding:5px;" class="uang">
                                    Rp <?php echo number_format($model->tandabuktikeluar->jmlkaskeluar,0,'','.');?>,-
                                </div>
                                <br>
                                <div colspan="2" class="catatan">
                                    LEMBAR I : Pasien<br>
                                    LEMBAR II : Ruangan<br>
                                    LEMBAR III : Arsip Keuangan<br>
                                </div>
                            </div>
                        </td>
                        <td class="tandatangan">

                            <?php echo Yii::app()->user->getState('kecamatan_nama') ?>, 
                            <?php 
                                    echo $format->formatDateTimeId(date('Y-m-d H:i:s'));

                            ?>

                            <br>
                            Petugas Kasir,<br><br><br><br>                           
                            <?php $pegawai = LoginpemakaiK::pegawaiLoginPemakai(); ?>
                            <b><?php echo empty($pegawai)?"-":$pegawai->nama_pegawai; ?></b><br>
                            <b style="border-top: 1px solid black;">NIP. <?php echo empty($pegawai)?"-":$pegawai->nomorindukpegawai; ?></b>

                            <?php echo CHtml::hiddenField('isprint',$tandabuktibayar->isprint); ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>
</table>

<?php if (isset($_GET['frame']) && $_GET['frame'] == 1) : ?>
<?php echo CHtml::htmlButton('<i class="icon-print icon-white"></i> Print', array(
    'onclick'=>'print()', 'class'=>'btn btn-info'
)); ?>

<script>

function print() {
    window.open('<?php echo $this->createUrl('returTagihan', array('tandabuktibayar_id' => $model->returbayarpelayanan_id)); ?>', 'printwin', 'left=100,top=100,width=800,height=400,scrollbars=1');
}

</script>

<?php endif; ?>