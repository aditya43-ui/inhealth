<table style='width:400px;'>
    <tr>
        <td>No. Resep </td>
        <td>:</td>
        <td><?php echo (isset($modPenjualan->noresep) ? $modPenjualan->noresep : "");?>
    </tr>
    <tr>
        <td>No. RM</td>
        <td>:</td>
        <td><?php echo (isset($pasien->no_rekam_medik) ? $pasien->no_rekam_medik : ""); ?>
    </tr>
    <tr>
        <td>Nama Pasien</td>
        <td>:</td>
        <td><?php echo (isset($pasien->nama_pasien) ? $pasien->nama_pasien : "");?>
    </tr>
    <tr>
        <td>Jenis Kelamin</td>
        <td>:</td>
        <td><?php echo (isset($pasien->jeniskelamin) ? $pasien->jeniskelamin : "");?>
    </tr>
    <tr>
        <td>Umur</td>
        <td>:</td>
        <td><?php echo (isset($daftar->umur) ? $daftar->umur : "");?>
    </tr>
</table><br/>
<table border="1" class='table table-striped table-bordered table-condensed'>
    <thead>
        <tr>
            <th>No.</th><th>Nama Obat</th><th>Jumlah</th><th>Harga Satuan</th><th>Keringanan</th><th>Sub Total</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $total = 0;
        foreach($obatAlkes as $i=>$rincian) {
            $diskon = $rincian->qty_oa* $rincian->hargasatuan_oa * (($rincian->discount > 0) ? $rincian->discount/100 : 0);
            $subTotal = ($rincian->qty_oa * $rincian->hargasatuan_oa)-$diskon;
            $total = $total + $subTotal;
        ?>
        <tr>
            <td><?php echo $i+1; ?></td>
            <td><?php echo $rincian->obatalkes->obatalkes_nama; ?></td>
            <td style="text-align: right;"><?php echo number_format($rincian->qty_oa); ?></td>
            <td style="text-align: right;"><?php echo "Rp. ".MyFormatter::formatNumberForPrint($rincian->hargasatuan_oa,2); ?></td>
            <td style="text-align: right;"><?php echo "Rp. ".MyFormatter::formatNumberForPrint($diskon,2); ?></td>
            <td style="text-align: right;"><?php echo "Rp. ".MyFormatter::formatNumberForPrint($subTotal,2); ?></td>
        </tr>
        <?php } ?>
        <tr>
            <td style="text-align: right;" colspan="5">Biaya Administrasi</td>
            <td style="text-align: right;"><?php echo "Rp. ".MyFormatter::formatNumberForPrint($modPenjualan->biayaadministrasi,2); ?></td>
        </tr>
         <tr>
            <td style="text-align: right;" colspan="5">Biaya Konseling</td>
            <td style="text-align: right;"><?php echo "Rp. ".MyFormatter::formatNumberForPrint($modPenjualan->biayakonseling,2); ?></td>
        </tr>
         <tr>
            <td style="text-align: right;" colspan="5">Total Tarif Service</td>
            <td style="text-align: right;"><?php echo "Rp. ".MyFormatter::formatNumberForPrint($modPenjualan->totaltarifservice,2); ?></td>
        </tr>
        <tr>
            <td style="text-align: right;" colspan="5">TOTAL</td>
            <td style="text-align: right;"><?php echo "Rp. ".MyFormatter::formatNumberForPrint(($total + $modPenjualan->biayaadministrasi + $modPenjualan->biayakonseling + $modPenjualan->totaltarifservice),2); ?></td>
        </tr>
    </tbody>
</table>
