<table id="tblListPemeriksaanLab" class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th>Tanggal Kirim Ke Laboratorium</th>
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
    
        $hasil = HasilpemeriksaanlabT::model()->findByAttributes(array(
            'pasienmasukpenunjang_id'=>$riwayat->pasienmasukpenunjang_id,
            'statusperiksahasil'=>'SUDAH',
        ));
    
	$modPermintaan = GZPermintaankepenunjangT::model()->with('daftartindakan','pemeriksaanlab')->findAllByAttributes(array('pasienkirimkeunitlain_id'=>$riwayat->pasienkirimkeunitlain_id));
	?>
    <tr>
        <td><?php echo $riwayat->tgl_kirimpasien; ?></td>
        <td><?php echo $riwayat->pasienkirimkeunitlain_id;?> </td>
        <td><?php
            foreach($modPermintaan as $j => $permintaan){
                echo strip_tags($permintaan->pemeriksaanlab->jenispemeriksaan->jenispemeriksaanlab_nama).'<br>';
            } ?></td>
        <td>
            <?php
            foreach($modPermintaan as $j => $permintaan){
                echo strip_tags($permintaan->pemeriksaanlab->pemeriksaanlab_nama).'<br>';
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
            
            if (empty($hasil)) {
                echo "<i>Belum  Diperiksa</i>";
            } else {
                $detail = DetailhasilpemeriksaanlabT::model()->findAllByAttributes(array(
                    'hasilpemeriksaanlab_id'=>$hasil->hasilpemeriksaanlab_id,
                ), array(
                    'order'=>'detailhasilpemeriksaanlab_id'
                ));
                
                
                
                if (count($detail) > 0) {
                    
                    $periksa_lab = array();
                    
                    foreach ($detail as $item) {
                        if (empty($periksa_lab[$item->pemeriksaanlab_id])) {
                            $periksa_lab[$item->pemeriksaanlab_id] = array(
                                'nama'=>$item->pemeriksaanlab->pemeriksaanlab_nama ?? "-",
                                'detail'=>array(),
                            );
                        }
                        $periksa_lab[$item->pemeriksaanlab_id]['detail'][] = $item;
                        
                    }
                    
                    foreach ($periksa_lab as $item) {
                        if (count($item['detail']) == 0) {
                            continue;
                        }
                        
                        echo $item['nama'];
                        echo "<ul>";
                        foreach ($item['detail'] as $item2) {
                            
                            echo "<li>";
                            echo $item2->pemeriksaandetail->nilairujukan->namapemeriksaandet." : ".($item2->hasilpemeriksaan ?? "-").(trim(strtolower($item2->hasilpemeriksaan_satuan)) == "null" ? "" : $item2->hasilpemeriksaan_satuan);
                            echo "</li>";
                        }
                        echo "</ul>";
                        
                    }
                } else {
                    echo "<i>Belum  Diperiksa</i>";
                }
            }
            
            ?>
        </td>
    </tr>
    <?php } ?>
    </tbody>
    
</table>