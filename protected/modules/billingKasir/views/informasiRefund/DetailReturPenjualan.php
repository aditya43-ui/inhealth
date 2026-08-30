<table>
    <tr>
        <td>Tgl. Retur</td>
        <td>:</td>
        <td><?php echo $modRetur->tglretur;?></td>
        <td></td>
        <td>No. Rekam Medik</td>
        <td>:</td>
        <td><?php echo $modRetur->pasien->no_rekam_medik;?></td>
    </tr> 
    <tr>
        <td>No. Retur Resep</td>
        <td>:</td>
        <td><?php echo $modRetur->noreturresep;?></td>
        <td></td>
        <td>Nama Pasien</td>
        <td>:</td>
        <td><?php echo $modRetur->pasien->nama_pasien;?></td>
    </tr>
    <tr>
        <td>Pegawai Retur</td>
        <td>:</td>
        <td><?php 
                    echo $modRetur->pegawairetur->nama_pegawai;
             ?></td>
        <td></td>
        <td>Mengetahui</td>
        <td>:</td>
        <td><?php echo $modRetur->pegawai->nama_pegawai;?></td>
    </tr>
</table>
<hr>
<table id="tableObatAlkes" class="table table-bordered table-condensed">
    <thead>
    
        <th>No.Urut</th>
        <th>Nama Obat</th>
        <th>Harga Satuan</th>
        <th>Jumlah Retur</th>
        <th>Satuan Kecil</th>
        <th>SubTotal</th>
    
    </thead>
    <?php
    $no=1;
	$subTotal=0;
        foreach($modDetailReturPenjualan AS $tampilData):
            $subTotal = $tampilData['qty_retur']*$tampilData['hargasatuan'];
    echo "<tr>
            <td>".$no."</td>
            <td>".$tampilData->obatpasien->obatalkes->obatalkes_nama."</td>  
            <td>".$tampilData->obatpasien->obatalkes->harganetto."</td>   
            <td>".$tampilData['qty_retur']."</td>   
            <td>".$tampilData->satuan->satuankecil_nama."</td>
            <td>".$subTotal."</td>
            
                      
         </tr>";  
        $no++;
       
        $totalSubTotal=$totalSubTotal+$subTotal;
        
        endforeach;  
     echo "<tr>
            <td colspan='5' style='text-align:right;'> Total</td>
           
            <td>".($totalSubTotal)."</td>
         </tr>"; 
    ?>
    
</table>
