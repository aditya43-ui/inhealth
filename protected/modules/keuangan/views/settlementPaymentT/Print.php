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
                    <td>Tgl. Settlement</td>
                    <td>: <?= MyFormatter::formatDateTimeForUser($model->tglsettlement)?></td>
                </tr>
                <tr>
                    <td>No.Settlement</td>
                    <td>: <?= $model->nosettlement?></td>
                </tr>
                <tr>
                    <td>Tgl. Pengajuan</td>
                    <td>: <?= MyFormatter::formatDateTimeForUser($model->advancepayment->tglpengajuan)?></td>
                </tr>

                <tr>
                    <td>No. Pengajuan</td>
                    <td>: <?=  $model->advancepayment->nopengajuan; ?></td>
                </tr>
                <?php if(isset($modBuktiBayar) && $model->jmlpembayaran  >0) { ?>
                <tr>
                    <td>Tgl. Kas Masuk</td>
                    <td>: <?= $modBuktiBayar ?  MyFormatter::formatDateTimeForUser($modBuktiBayar->tglbuktibayar) : '-'?></td>
                </tr>
                <tr>
                    <td>No. Kas Masuk</td>
                    <td>: <?=  $modBuktiBayar ?  $modBuktiBayar->nobuktibayar : '-'; ?></td>
                </tr>
                <?php } ?>
                <?php if(isset($modTandaBuktiKeluar)) { ?>
                    <tr>
                        <td>Tgl. Kas Keluar</td>
                        <td>: <?=  MyFormatter::formatDateTimeForUser($modTandaBuktiKeluar->tglkaskeluar); ?></td>
                    </tr>
                    <tr>
                        <td>No. Kas Keluar</td>
                        <td>: <?=  $modTandaBuktiKeluar->nokaskeluar; ?></td>
                    </tr>
                    <tr>
                        <td>Nama Penerima</td>
                        <td>: <?=  $model->terimadari; ?></td>
                    </tr>
                <?php } ?>

            </table>
        </td>
        <td width="50%" style="vertical-align: top;">
            <table width="100%">
                <?php if(isset($modTandaBuktiKeluar)) { ?>
                <tr>
                    <td>Cara Pembayaran</td>
                    <td>: <?= $modTandaBuktiKeluar->carabayarkeluar; ?></td>
                </tr>
                <?php } ?>
                <tr>
                    <td>Jumlah Pembayaran Advance Payment</td>
                    <td>: Rp.<?= number_format($model->jmladvance,2,',','.'); ?></td>
                </tr>
                <tr>
                    <td>Realisasi Pembelian</td>
                    <td>: Rp.<?= number_format($model->realisasipembelian,2,',','.'); ?></td>
                </tr>
                <?php if(!isset($modTandaBuktiKeluar)) { ?>
                <tr>
                    <td>Sisa Advance Payment</td>
                    <td>: Rp.<?= number_format($model->sisarealisasi,2,',','.'); ?></td>
                </tr>
                <?php } ?>
                <?php if(isset($modTandaBuktiKeluar)) { ?>
                    <tr>
                        <td>Hutang Realisasi Pembelian</td>
                        <td>: Rp.<?= number_format($model->kekuranganrealisasi,2,',','.'); ?></td>
                    </tr>
                    <tr>
                        <td>Jumlah Pembayaran</td>
                        <td>: Rp.<?= number_format($model->jmlpembayaran,2,',','.'); ?></td>
                    </tr>
                    <tr>
                        <td>Biaya Administrasi</td>
                        <td>: Rp.<?= number_format($modTandaBuktiKeluar->biayaadministrasi,2,',','.'); ?></td>
                    </tr>
                    <tr>
                        <td>Jumlah Kas Keluar</td>
                        <td>: Rp.<?= number_format($modTandaBuktiKeluar->jmlkaskeluar,2,',','.'); ?></td>
                    </tr>
                    <tr>
                        <td>Sisa Hutang Realisasi Pembelian</td>
                        <td>: Rp.<?= number_format($model->sisakekurangan,2,',','.'); ?></td>
                    </tr>
                <?php } ?>
                <?php if($model->jmlpembayaran  > 0 && !isset($modTandaBuktiKeluar) ) { ?>
                <tr>
                    <td>Jumlah Pengembalian</td>
                    <td>: Rp.<?= number_format($model->jmlpembayaran,2,',','.'); ?></td>
                </tr>
                <tr>
                    <td>Jumlah Kas Masuk </td>
                    <td>: Rp.<?= $modBuktiBayar ? number_format($modBuktiBayar->jmlpembayaran,2,',','.') : '-'; ?></td>
                </tr>
                <tr>
                    <td>Sisa Pengembalian Advance Payment</td>
                    <td>: Rp.<?= number_format($model->sisapengembalian,2,',','.'); ?></td>
                </tr>
                <?php }  if($model->ispotonggaji) { ?>
                <tr>
                    <td>Jumlah Pengembalian</td>
                    <td>: Rp.<?= number_format($model->jmlpembayaran,2,',','.'); ?></td>
                </tr>
                <tr>
                    <td>Jumlah Kas Masuk </td>
                    <td>: Rp.<?= $modBuktiBayar ? number_format($modBuktiBayar->jmlpembayaran,2,',','.') : '-'; ?></td>
                </tr>
                <tr>
                    <td>Sisa Pengembalian Advance Payment</td>
                    <td>: Rp.<?= number_format($model->sisapengembalian,2,',','.'); ?></td>
                </tr>
                <tr>
                    <td>Potong Gaji</td>
                    <td>: <?= $model->ispotonggaji ? 'Ya': 'Tidak'?></td>
                </tr>
                <tr>
                    <td>Total Pemotongan Gaji</td>
                    <td>: Rp.<?= number_format($model->totalpotongan,2,',','.'); ?></td>
                </tr>
                <?php } ?>
                <?php if($model->totalpiutang > 0){ ?>
                    <tr>
                    <td>Jumlah Pengembalian</td>
                    <td>: Rp.<?= number_format($model->jmlpembayaran,2,',','.'); ?></td>
                </tr>
                <tr>
                    <td>Jumlah Kas Masuk </td>
                    <td>: Rp.<?= $modBuktiBayar ? number_format($modBuktiBayar->jmlpembayaran,2,',','.') : '-'; ?></td>
                </tr>
                <tr>
                    <td>Sisa Pengembalian Advance Payment</td>
                    <td>: Rp.<?= number_format($model->sisapengembalian,2,',','.'); ?></td>
                </tr>
                    <tr>
                        <td>Piutang Pegawai</td>
                        <td>: Ya</td>
                    </tr>
                    <tr>
                        <td>Total Piutang</td>
                        <td>: Rp.<?= number_format($model->totalpiutang,2,',','.'); ?></td>
                    </tr>
                    <tr>
                        <td>Tgl. Jatuh Tempo</td>
                        <td>: <?= MyFormatter::formatDateTimeForUser(date('Y-m-d',strtotime($model->tgljatuhtempo))) ?></td>
                    </tr>
                <?php } ?>
                <?php if($model->totalhutang > 0){ ?>
                    <tr>
                    <td>Hutang Realisasi Pembelian</td>
                    <td>: Rp.<?= number_format($model->kekuranganrealisasi,2,',','.'); ?></td>
                </tr>
                <tr>
                    <td>Sisa Hutang Realisasi Pembelian</td>
                    <td>: Rp.<?= number_format($model->sisakekurangan,2,',','.'); ?></td>
                </tr>
                    <tr>
                        <td>Hutang</td>
                        <td>: Ya</td>
                    </tr>
                    <tr>
                        <td>Total Hutang</td>
                        <td>: Rp.<?= number_format($model->totalhutang,2,',','.'); ?></td>
                    </tr>
                    <tr>
                        <td>Tgl. Jatuh Tempo</td>
                        <td>: <?= MyFormatter::formatDateTimeForUser(date('Y-m-d',strtotime($model->tgljatuhtempo))) ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>

    <tr>
        <td colspan="2" style="text-align: center;">URAIAN TRANSAKSI</td>
    </tr>
    <tr>
        <td colspan="2"><hr></td>
    </tr>
    <tr>
        <td colspan="2">
            <table width="100%" class="table table-bordered">
                <tr>
                    <th>Tgl. Transaksi</th>
                    <th>Jenis Pengeluaran</th>
                    <th>Deskripsi</th>
                    <th>No Referensi</th>
                    <th>Volume</th>
                    <th>Satuan</th>
                    <th>Harga</th>
                    <th>Total Harga</th>
                </tr>
                <?php foreach($modDetails as $det) { ?>
                <tr>
                    <td style="text-align: center;"><?= MyFormatter::formatDateTimeForUser($det['tgltransaksi'])?></td>
                    <td style="text-align: center;"><?= $det['jenispengeluaran_id'] ?  JenispengeluaranM::model()->findByPk($det['jenispengeluaran_id'])->jenispengeluaran_nama : '' ?></td>
                    <td style="text-align: center;"><?= $det['deskripsi'];?></td>
                    <td style="text-align: center;"><?= $det['noreferensi'];?></td>
                    <td style="text-align: center;"><?= $det['volume'];?></td>
                    <td style="text-align: center;"><?= $det['satuanvol'];?></td>
                    <td style="text-align: right;">Rp.<?= number_format($det['hargasatuan'],2,',','.');?></td>
                    <td style="text-align: right;">Rp.<?= number_format($det['totalharga'],2,',','.');?></td>
                </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <table width="100%">
                <tr>
                    <td style="text-align: center;">
                        <p>Pegawai yang mengajukan,</p>
                        <br><br><br><br><br>
                        <p>(<?= $model->advancepayment->pegawai->namaLengkap; ?>)</p>
                    </td>
                    <td style="text-align: center;">
                        <p>Pegawai pemeriksa,</p>
                        <br><br><br><br><br>
                        <p><?= $model->advancepayment->pegawaipemeriksa->namaLengkap; ?></p>
                    </td>
                    <td style="text-align: center;">
                        <p>Pegawai Menyetujui,</p>
                        <br><br><br><br><br>
                        <p><?= $model->advancepayment->pegawaimenyetujui->namaLengkap; ?></p>
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
