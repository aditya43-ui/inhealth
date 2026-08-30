<table>
    <tr>
        <td>Tgl. Penjualan</td>
        <td>:</td>
        <td><?php echo $modReseptur->tglpenjualan;?></td>
        <td></td>
        <td>No. Rekam Medik</td>
        <td>:</td>
        <td><?php echo $modReseptur->pasien->no_rekam_medik;?></td>
    </tr> 
    <tr>
        <td>Tgl. Resep</td>
        <td>:</td>
        <td><?php echo $modReseptur->tglresep;?></td>
        <td></td>
        <td>Nama Pasien</td>
        <td>:</td>
        <td><?php echo $modReseptur->pasien->nama_pasien;?></td>
    </tr>
    <tr>
         <td><?php echo ($modReseptur->jenispenjualan == Params::JENISPENJUALAN_BEBAS) ? 'No. Nota' : "No. Resep";?></td>
        <td>:</td>
        <td><?php 
                    echo $modReseptur->noresep;
             ?></td>
        <td></td>
        <td>Dokter</td>
        <td>:</td>
        <td><?php echo  ($modReseptur->jenispenjualan == Params::JENISPENJUALAN_RESEP OR  $modReseptur->jenispenjualan == Params::JENISPENJUALAN_RESEP_LUAR) ? '-' : $modReseptur->pegawai->nama_pegawai;?></td>
    </tr>
</table>
<hr>
<table id="tableObatAlkes" class="table table-bordered table-condensed">
    <thead>
    
        <th>No.Urut</th>
        <th>Sumber Dana</th>
        <th>Kategori/&nbsp;&nbsp;&nbsp;&nbsp;<br>Nama Obat</th>
        <th>Satuan Kecil</th>
        <th>Jumlah</th>
        <th>Harga Satuan</th>
        <th>Keringanan</th>
        <th>SubTotal</th>
        <th>Status Bayar</th>
    
    </thead>
    <?php
    $no=1;
        foreach($detailreseptur AS $tampilData):
            $subTotal = (($tampilData['qty_oa']*$tampilData['hargasatuan_oa']));
            $discount = ((($tampilData['hargasatuan_oa']*$tampilData['qty_oa'])*($tampilData['discount']/100)));
            if($tampilData['oasudahbayar_id'] != null){
                 $status = 'Sudah Lunas';
            }else{
                 $status = 'Belum Lunas';
            }
    echo "<tr>
            <td>".$no."</td>
            <td>".$tampilData->obatalkes->sumberdana->sumberdana_nama."</td>  
            <td>".$tampilData->obatalkes->obatalkes_kategori."<br>".$tampilData->obatalkes->obatalkes_nama."</td>   
            <td>".$tampilData->obatalkes->satuankecil->satuankecil_nama."</td>   
            <td>".$tampilData['qty_oa']."</td>
            <td>".$tampilData['hargasatuan_oa']."</td> 
            <td>".$discount."</td> 
            <td>".number_format($subTotal-$discount)."</td>
            <td>".$status."</td>
            
                      
         </tr>";  
        $no++;
       
        $subtotals += ceil($subTotal-$discount);
//        $discounts +=$discount;
        $totalSubTotal=$totalSubTotal+$subTotal-$discount;
        
        endforeach;  
    echo "<tr>
            <td colspan='7' style='text-align:right;'> Biaya Administrasi</td>
           
            <td>".$modReseptur->biayaadministrasi."</td>
            <td></td>
         </tr>";   
    echo "<tr>
            <td colspan='7' style='text-align:right;'> Biaya Service</td>
           
            <td>".$modReseptur->totaltarifservice."</td>
            <td></td>
         </tr>";   
    echo "<tr>
            <td colspan='7' style='text-align:right;'> Biaya Konseling</td>
           
            <td>".$modReseptur->biayakonseling."</td>
            <td></td>
         </tr>";  
    echo "<tr>
            <td colspan='7' style='text-align:right;'> Jasa Dokter Resep</td>
           
            <td>".$modReseptur->jasadokterresep."</td>
            <td></td>
         </tr>";  
    echo "<tr>
            <td colspan='7' style='text-align:right;'> Keringanan</td>
           
            <td>".$modReseptur->discount."</td>
            <td></td>
         </tr>";  
     //     echo "<tr>
//            <td colspan='7' style='text-align:right;'> Total</td>
//           
//            <td>".number_format((($totalSubTotal) - ($totalSubTotal * ($modReseptur->discount/100))) + $modReseptur->biayaadministrasi+$modReseptur->biayakonseling+$modReseptur->totaltarifservice+$modReseptur->jasadokterresep)."</td>
//            <td></td>
//         </tr>"; 
    $total = $subtotals+$modReseptur->biayaadministrasi+$modReseptur->totaltarifservice+$modReseptur->biayakonseling; //+$modReseptur->jasadokterresep << SDH TERMASUK DLM HARGA OBAT
     echo "<tr>
            <td colspan='7' style='text-align:right;'> Total</td>
           
            <td>".number_format($total)."</td>
            <td></td>
         </tr>";  
    ?>
    
</table>