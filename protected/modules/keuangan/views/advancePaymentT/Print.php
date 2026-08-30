<style>
    body {
        color: black;
        font-size: 12px;
    }
    
    .tab_header, .tab_detail {
        width:100%;
    }
    
    .tab_detail th {
        text-align: center;
    }
    
    .tab_detail td, .tab_detail th {
        border: 1px solid black;
        padding: 2px;
    }
</style>

<?php
//if (isset($caraPrint)){
//    echo $this->renderPartial('application.views.headerReport.headerDefault', array('judulLaporan'=>$judulKuitansi));      
//}
echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDFNewByKlinik',array('profilrs_id'=>$model->profilrs_id,'judulLaporan'=>$judulKuitansi, 'deskripsi'=>"", 'colspan'=>10));
?>



<?php
echo CHtml::css('.control-label{
        float:left; 
        text-align: right; 
        width:120px;
        color:black;
        padding-right:10px;
    }
    table{
        font-size:13px;
    }

    td .tengah{
       text-align: center;  
    }
');
?>
<br>
<table width="100%"  style="margin:0px;" cellpadding="0" cellspacing="0">
    <tr>
        <td width="50%">
            <table width="100%" class="tab_header">
                <tr>
                    <td>Klinik</td>
                    <!-- <td>:</td> -->
                    <td>: <?= $model->profilrs->nama_rumahsakit; ?></td>
                </tr>
                <tr>
                    <td>Tgl.Pengajuan</td>
                    <td>: <?= MyFormatter::formatDateTimeForUser($model->tglpengajuan)?></td>
                </tr>
                <tr>
                    <td>Tgl. Kas Keluar</td>
                    <td>: <?= $modBuktiKeluar ?  MyFormatter::formatDateTimeForUser($modBuktiKeluar->tglkaskeluar) : '-'?></td>
                </tr>
                <tr>
                    <td>No.Pengajuan</td>
                    <td>: <?= $model->nopengajuan?></td>
                </tr>
                <tr>
                    <td>No. Kas Keluar</td>
                    <td>: <?= $modBuktiKeluar ? $modBuktiKeluar->nokaskeluar : '-'; ?></td>
                </tr>
                <tr>
                    <td>No. Dokumen</td>
                    <td>: <?= $model->nodokumen; ?></td>
                </tr>
                <tr>
                    <td>No. Anggaran</td>
                    <td>: <?= $model->noanggaran ?></td>
                </tr>
                <tr>
                    <td>Keterangan Pengajuan</td>
                    <td>: <?= $model->keterangan ?></td>
                </tr>
            </table>
        </td>
        <td width="50%" style="vertical-align: top;">
            <table width="100%">
            <tr>
                    <td>Cara Pembayaran</td>
                    <td>: <?= $modBuktiKeluar ?  $modBuktiKeluar->carabayarkeluar : '-'; ?></td>
                </tr>
                <?php if(isset($modBuktiKeluar) && $modBuktiKeluar->carabayarkeluar == 'TRANSFER')  { ?>
                    <tr>
                        <td>Nama Bank Pengirim</td>
                        <td>: <?= $modBuktiKeluar ? $modBuktiKeluar->bank->bankDanAtasNama : '-'; ?></td>
                    </tr>
                    <tr>
                        <td>Nama Bank Penerima</td>
                        <td>: <?= $modBuktiKeluar ? $modBuktiKeluar->melalubank : '-'; ?></td>
                    </tr>
                <?php } ?>

                <tr>
                    <td>Catatan Pembayaran</td>
                    <td>: <?= $model->catatanpembayaran; ?></td>
                </tr>
                <tr>
                    <td>Jumlah Pembayaran</td>
                    <td>: Rp.<?= number_format($model->jmlpembayaran,2,',','.'); ?></td>
                </tr>
                <tr>
                    <td>Biaya Administrasi</td>
                    <td>: Rp.<?= $modBuktiKeluar ? number_format($modBuktiKeluar->biayaadministrasi,2,',','.') : '-'; ?></td>
                </tr>
                <tr>
                    <td>Jumlah Kas Keluar</td>
                    <td>: Rp.<?= $modBuktiKeluar ? number_format($modBuktiKeluar->jmlkaskeluar,2,',','.') : '-'; ?></td>
                </tr>
                
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2">
            <table width="100%">
                <tr>
                    <td style="text-align: center;">
                        <p>Pegawai yang mengajukan,</p>
                        <br><br><br><br><br>
                        <p>(<?= $model->pegawai->namaLengkap; ?>)</p>
                    </td>
                    <td style="text-align: center;">
                        <p>Pegawai pemeriksa,</p>
                        <br><br><br><br><br>
                        <p><?= $model->pegawaipemeriksa->namaLengkap; ?></p>
                    </td>
                    <td style="text-align: center;">
                        <p>Pegawai Menyetujui,</p>
                        <br><br><br><br><br>
                        <p><?= $model->pegawaimenyetujui->namaLengkap; ?></p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<br>
<?php
if (isset($_GET['frame'])){
    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')"));
   // echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('EXCEL')")); 
?>
    <script type='text/javascript'>
    /**
     * print
     */    
    function print(caraPrint){
     
        window.open('<?php echo $this->createUrl('print'); ?>&advancepayment_id='+<?php echo $model->advancepayment_id ?>+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
    }
    </script>
<?php
}