<table id="tblListPemeriksaanLab" class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th>Tanggal Kirim Ke Radiologi</th>
            <th>No. Permintaan</th>
            <th>Jenis Pemeriksaan</th>
            <th>Permintaan Pemeriksaan</th>
            <th>Jumlah</th>
            <th>Hasil Pemeriksaan</th>
        </tr>
    </thead>
    <tbody>
<?php
foreach ($modRiwayatKirimKeUnitLain as $i => $riwayat) {
	$modPermintaan = GZPermintaankepenunjangT::model()->with('daftartindakan','pemeriksaanlab')->findAllByAttributes(array('pasienkirimkeunitlain_id'=>$riwayat->pasienkirimkeunitlain_id));
	
        
        $hasil = HasilpemeriksaanradT::model()->findAllByAttributes(array(
            'pasienmasukpenunjang_id'=>$riwayat->pasienmasukpenunjang_id,
            'statusperiksahasil'=>'SUDAH',
        ));
        
        ?>
    <tr>
        <td><?php echo $riwayat->tgl_kirimpasien; ?></td>
        <td><?php echo $riwayat->pasienkirimkeunitlain_id;?> </td>
        <td><?php
            foreach($modPermintaan as $j => $permintaan){
                echo strip_tags($permintaan->pemeriksaanrad->jenispemeriksaanrad->jenispemeriksaanrad_nama).'<br>';
            } ?></td>
        <td>
            <?php
            foreach($modPermintaan as $j => $permintaan){
                echo strip_tags($permintaan->pemeriksaanrad->pemeriksaanrad_nama).'<br>';
            } ?>
        </td>
        <td>
            <?php
            foreach($modPermintaan as $j => $permintaan){
                echo $permintaan->qtypermintaan.'<br>';
            } ?>
        </td>
	<td>
	    <?php
	    if(count($hasil) > 0){
		foreach ($hasil as $item) {
                    echo $item->pemeriksaanrad->pemeriksaanrad_nama."<br/>";
                    echo "<ul>";
                    echo "<li>Ekspertise : ".$item->hasilexpertise;
                    echo "</li>";
                    echo "<li>Kesimpulan : ".$item->kesimpulan_hasilrad;;
                    echo "</li>";
                    echo "</ul>";
                }
	    }else{
		echo "<i>Belum Diperiksa</i>";
	    }
	    ?>
	</td>
    </tr>
    <?php } ?>
    </tbody>
    
</table>
