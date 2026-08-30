<table id="tblListPemeriksaanLab" class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th>Tanggal Kirim Ke Bedah Sentral</th>
            <th>No. Permintaan</th>
            <th>Permintaan Pemeriksaan</th>
            <th>Jumlah</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
<?php
foreach ($modRiwayatKirimKeUnitLain as $i => $riwayat) {
	$modPermintaan = GZPermintaankepenunjangT::model()->with('daftartindakan','pemeriksaanlab')->findAllByAttributes(array('pasienkirimkeunitlain_id'=>$riwayat->pasienkirimkeunitlain_id));
	?>
    <tr>
        <td><?php echo $riwayat->tgl_kirimpasien; ?></td>
        <td><?php echo $riwayat->pasienkirimkeunitlain_id;?> </td>
        <td>
            <?php
            foreach($modPermintaan as $j => $permintaan){
                echo strip_tags($permintaan->operasi->operasi_nama).'<br>';
            } ?>
        </td>
        <td>
            <?php
            foreach($modPermintaan as $j => $permintaan){
                echo $permintaan->qtypermintaan.'<br>';
            } ?>
        </td>
    </tr>
    <?php } ?>
    </tbody>
    
</table>