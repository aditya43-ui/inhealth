<style>
    td {
        vertical-align: top;
        padding-bottom: 10px;
    }
</style>

<div class="row">
    <div class="col-sm-4">
        <table>
            <tr>
                <td style="width: 120px; padding-right: 10px;">No. Invoice</td>
                <td><?php echo $modInvoice->invoicetagihan_no ?></td>
            </tr>
            <tr>
                <td>Tgl. Invoice</td>
                <td><?php echo $modInvoice->invoicetagihan_tgl ?></td>
            </tr>
            <tr>
                <td>Dari</td>
                <td><?php echo $modInvoice->namapenagih ?></td>
            </tr>
            <tr>
                <td>Perihal</td>
                <td><?php echo $modInvoice->perihal_tagihan ?></td>
            </tr>
        </table>
    </div>
    <div class="col-sm-4">
        <table>
            <tr>
                <td style="width: 120px; padding-right: 10px;">Rekanan</td>
                <td><?php echo $modInvoice->rekanan_tagihan ?></td>
            </tr>
            <tr>
                <td>Keterangan Pembayaran</td>
                <td><?php echo $modInvoice->ket_pembayaran ?></td>
            </tr>
            <tr>
                <td>Isi Surat</td>
                <td><?php echo $modInvoice->isisurat_tagihan ?></td>
            </tr>
        </table>
    </div>
    <div class="col-sm-4">
        <table>
            <tr>
                <td style="width: 120px; padding-right: 10px;">Status Verifikasi</td>
                <td><?php echo $modInvoice->status_verifikasi == 1 ? 'Sudah Verifikasi' : 'Belum Verifikasi' ?></td>
            </tr>
            <tr>
                <td>Tanggal Verifikasi</td>
                <td><?php echo $modInvoice->tgl_verfikasi_tagihan ?></td>
            </tr>
            <tr>
                <td>Nama Verifikasi RS Luar</td>
                <td><?php echo $modInvoice->verifikator_nama ?></td>
            </tr>
        </table>
    </div>
</div>

<br>
<div class="block-tabel">
    <h6>Data Detail</h6>
    <table id="tableObatAlkes" class="table table-striped table-bordered table-condensed">
        <thead>
            <th>No.</th>
            <th>Uraiang</th>
            <th>Total</th>
            <th>Keterangan</th>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $total = 0;
            foreach ($modTagDet as $detailTagihan) :
                $total += $detailTagihan->total_tagdetail;
            ?>
                <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $detailTagihan->uraian_tagdetail; ?></td>
                    <td><?php echo MyFormatter::formatUang($detailTagihan->total_tagdetail); ?></td>
                    <td><?php echo $detailTagihan->ket_tagdetail; ?></td>
                </tr>
            <?php
                $no++;
            endforeach;
            ?>
            <tr>
                <td></td>
                <td></td>
                <td>Total Tagihan</td>
                <td><?php echo MyFormatter::formatUang($total); ?></td>
            </tr>
        </tbody>
    </table>
</div>
<div class="block-tabel">
    <h6>Data Disposisi</h6>
    <table id="tableObatAlkes" class="table table-striped table-bordered table-condensed">
        <thead>
            <th>No.</th>
            <th>Uraiang</th>
            <th>Total</th>
            <th>Keterangan</th>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($modDetPosisi as $detailPosisi) : ?>
                <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $detailPosisi->uraian_disoposisi; ?></td>
                    <td><?php echo MyFormatter::formatUang($detailPosisi->total_disposisi); ?></td>
                    <td><?php echo $detailPosisi->ket_disposisi; ?></td>
                </tr>
            <?php
                $no++;
            endforeach;
            ?>
        </tbody>
    </table>
</div>
<table width="100%" style="margin-top:20px;">
    <tr>
        <td width="100%" align="left" align="top">
            <table style="width: 100%; border: none;">
                <tr>
                    <td width="35%" align="center">
                        <div><?php echo $modInvoice->disetujui_posisi ?><br></div>
                        <div style="margin-top:60px;"><?php echo $modInvoice->disetujui_nama ?></div>
                    </td>
                    <td width="35%" align="center">
                    </td>
                    <td width="35%" align="center">
                        <div><?php echo $modInvoice->verifikator_posisi ?></div>
                        <div style="margin-top:60px;"><?php echo $modInvoice->verifikator_nama ?></div>
                        <div></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<?php echo CHtml::htmlButton(
    Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')),
    array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')
);
?>
<script type="text/javascript">
    function print(caraPrint) {
        var id = <?php echo $_GET['id']; ?>;
        var url = '<?php echo $this->createUrl("Print"); ?>';
        window.open(url + "&id=" + id + "&caraPrint=" + caraPrint, "", 'location=_new, width=900px');
    }
</script>