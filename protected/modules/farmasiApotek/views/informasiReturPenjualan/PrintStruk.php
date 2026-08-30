<table>
    <tr>
        <td colspan="3">
            <table>
                <tr>
                    <td>
                        <?php echo $this->renderPartial('application.views.headerReport.headerDefault'); ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table style="margin-left:10px">
    <tr>
        <td>Tgl. Penjualan</td>
        <td>:</td>
        <td><?php echo $modReseptur->penjualanresep->tglpenjualan;?></td>
        <td></td>
        <td>No. Rekam Medik</td>
        <td>:</td>
        <td><?php echo $modReseptur->pasien->no_rekam_medik;?></td>
    </tr> 
    <tr>
        <td>Tgl. Resep</td>
        <td>:</td>
        <td><?php echo $modReseptur->penjualanresep->tglresep;?></td>
        <td></td>
        <td>Nama Pasien</td>
        <td>:</td>
        <td><?php echo $modReseptur->pasien->nama_pasien;?></td>
    </tr>
    <tr>
        <td>No. Resep</td>
        <td>:</td>
        <td><?php echo $modReseptur->penjualanresep->noresep;?></td>
        <td></td>
        <td>Dokter</td>
        <td>:</td>
        <td><?php echo $modReseptur->penjualanresep->pegawai->nama_pegawai;?></td>
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
        <th>SubTotal</th>
    
    </thead>
    <?php
    $no=1;
        foreach($modDetailPenjualan AS $tampilData):
            $subTotal = $tampilData['qty_oa']*$tampilData['hargasatuan_oa'];
//            if($tampilData['oasudahbayar_id'] != null){
//                echo $status = 'Sudah Lunas';
//            }else{
//                echo $status = 'Belum Lunas';
//            }
    echo "<tr>
            <td>".$no."</td>
            <td>".$tampilData['sumberdana_nama']."</td>  
            <td>".$tampilData['obatalkes_kategori']."<br>".$tampilData['obatalkes_nama']."</td>   
            <td>".$tampilData['satuankecil_nama']."</td>   
            <td>".$tampilData['qty_oa']."</td>
            <td>".$tampilData['hargasatuan_oa']."</td> 
            <td>".$subTotal."</td>
            
                      
         </tr>";  
        $no++;
       
        $totalSubTotal=$totalSubTotal+$subTotal;
        
        endforeach;
    echo "<tr>
            <td colspan='6' style='text-align:right;'> Total</td>
           
            <td>".$totalSubTotal."</td>
         </tr>";    
    ?>
    
</table>