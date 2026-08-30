<style>
    .border th,
    .border td {
        border: 1px solid #000;
        padding: 2px;
    }

    .table thead:first-child {
        border-top: 1px solid #000;
    }

    thead th {
        background: none;
        color: #333;
    }

    .table tbody tr:hover td,
    .table tbody tr:hover th {
        background-color: none;
    }
</style>
<?php
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)) {
    $template = "{items}";
    if ($caraPrint == 'EXCEL') {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
        header('Cache-Control: max-age=0');
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
}
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
echo $this->renderPartial('application.views.headerReport.headerRincian');
//echo $this->renderPartial('application.views.headerReport.headerAnggaran',array('judulLaporan'=>$judulLaporan, 'deskripsi'=>$deskripsi, 'colspan'=>10));
?>
<table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center" valig="middle" colspan="2">
            <b>
                <h3><?php echo $judulLaporan; ?></h3>
            </b>
        </td>
    </tr>

</table> <br>
<table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
    <tr>
        <td style="width:150px">No. Rencana</td>
        <td style="width:10px">:</td>
        <td><?php echo $model->renkebbahanmakanan_no; ?></td>

        <td style="width:150px">Sumber Dana</td>
        <td style="width:10px">:</td>
        <td>
            <h4><?php echo (!empty($model->sumberdana_id) ? $model->sumberdana->sumberdana_nama : ""); ?>
        </td>
    </tr>
    <tr>
        <td>Tanggal Rencana : </td>
        <td>:</td>
        <td><?php echo $format->formatDateTimeForUser(MyFormatter::formatDateTimeForUser($model->renkebbahanmakanan_tgl)); ?></td>
    </tr>
</table><br>
<!--<br>-->
<!--<table width="74%" style="margin: 0;" cellpadding="0" cellspacing="0">
        <tr>
            <td width="20%">No. Rencana</td>
            <td>:</td>
            <td><?php echo $model->renkebbahanmakanan_no; ?></td>
        </tr>
    </table>-->

<table class="table" style="box-shadow:none;" id="table-rencanaanggaranpenerimaan">
    <thead>
        <tr class="border">
            <th class="border" style="text-align: center;">No.</th>
            <th class="border" style="text-align: center;">Golongan</th>
            <th class="border" style="text-align: center;">Jenis</th>
            <th class="border" style="text-align: center;">Kelompok</th>
            <th class="border" style="text-align: center;">Nama Bahan Makanan</th>
            <th class="border" style="text-align: center;">Satuan </th>
            <th class="border" style="text-align: center;">Stok Akhir</th>
            <th class="border" style="text-align: center;">Minimal Stok</th>
            <th class="border" style="text-align: center;">Maksimal Stok</th>
            <th class="border" style="text-align: center;">Jumlah Kebutuhan</th>
            <th class="border" width="75" style="text-align: center;">Harga</th>
            <th class="border" style="text-align: center;">PPN (%)</th>
            <th class="border" style="text-align: center;">PPN (Rp)</th>
            <th class="border" width="75" style="text-align: center;">Sub Total</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $total = 0;
        $subtotal = 0;
        foreach ($modDetails as $i => $modBarang) {
            $barang = BahanmakananM::model()->findByPk($modBarang->bahanmakanan_id);
            $gol_nama = "";
            if (!empty($barang->golbahanmakanan_id)) {
                $gol = GolbahanmakananM::model()->findByPk($barang->golbahanmakanan_id);
                if (!empty($gol)) {
                    $gol_nama = $gol->golbahanmakanan_nama;
                }
            }
            $jmlTotal = ($modBarang->harga_barangdet * $modBarang->jmlpermintaandet);
            $jmlppn = (($jmlTotal * $modBarang->persen_ppn) / 100);
            $subtotal = ($jmlTotal + $jmlppn);
            $total += $subtotal;
        ?>
            <tr class="border">
                <td class="border" style="text-align: center;"><?php echo ($i + 1) . "."; ?></td>
                <td class="border"><?php echo $gol_nama; ?></td>
                <td class="border"><?php echo $barang->jenisbahanmakanan; ?></td>
                <td class="border"><?php echo $barang->kelbahanmakanan; ?></td>
                <td class="border"><?php echo (!empty($modBarang->bahanmakanan_id)) ? $barang->namabahanmakanan : ""; ?></td>
                <td class="border" style="text-align: center;"><?php echo $modBarang->satuanbahan; ?></td>
                <td class="border" style="text-align: center;" nowrap><?php echo $modBarang->stokakhir_bahanmakanan; ?></td>
                <td class="border" style="text-align: center;" nowrap><?php echo $modBarang->minstok_bahanmakanan; ?></td>
                <td class="border" style="text-align: center;" nowrap><?php echo $modBarang->makstok_bahanmakanan; ?></td>
                <td class="border" style="text-align: center;"><?php echo number_format($modBarang->jmlpermintaandet, 2, ",", "."); ?></td>
                <td class="border" style="text-align: right;" nowrap><?php echo (Params::cekHiddenHargaGizi() == true) ? "Rp " . number_format($modBarang->harga_barangdet, 2, ",", ".") : "Hidden"; ?></td>
                <td class="border" style="text-align: center;"><?php echo $modBarang->persen_ppn; ?></td>
                <td class="border" style="text-align: right;" nowrap><?php echo (Params::cekHiddenHargaGizi() == true) ? "Rp " . number_format($jmlppn, 2, ",", ".") : "Hidden"; ?></td>
                <td class="border" style="text-align: right;" nowrap><?php
                                                                        echo (Params::cekHiddenHargaGizi() == true) ? "Rp " . number_format($subtotal, 2, ",", ".") : 'Hidden'; ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr class="border">
            <td class="border" colspan="13" style="text-align:right;"><b>Total (Rp)</b></td>
            <td class="border" style="text-align:right;"><b>
                    <?php echo (Params::cekHiddenHargaGizi() == true) ? number_format($total, 2, ",", ".") : "Hidden"; ?>
                </b>
            </td>
        </tr>
    </tfoot>
</table><br>
<table style="width: 100%; border: none;">
    <tr>
        <th></th>
        <th style="width:50%; text-align:center; padding-bottom: 50px;" colspan="2">
            <?php
            if (isset($model->tglmenyetujui)) { ?>
                Kepala Instalasi Gizi,
                <br><br><br><br><br><br>
                ( <?php echo isset($model->pegmenyetujui_id) ? $model->pegawaimenyetujui->namaLengkap : ""; ?> )
            <?php } ?>
        </th>
        <!--		<th style="width:50%; text-align:center; padding-bottom: 50px;" colspan="2">
			Mengetahui,
			<br><br><br><br><br><br>
			( <?php // echo isset($model->pegmengetahui_id)?$model->pegawaimengetahui->namaLengkap:"";;
                ?> )
		</th>-->
    </tr>
</table>