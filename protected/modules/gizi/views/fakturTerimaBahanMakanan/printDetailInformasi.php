<style>
    .border{
        border:1px solid #000;
    }
    .table thead:first-child{
        border-top:1px solid #000;        
    }
    
    thead th{
        background:none;
        color:#333;
    }
    
    .table tbody tr:hover td, .table tbody tr:hover th {
        background-color: none;
    }
</style>
<?php  //echo $this->renderPartial('_headerPrint'); ?>
<?php echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF',array('judulLaporan'=>$judulLaporan,  'periode'=> '', 'colspan'=>10)); ?>
<table  class="table" style = "box-shadow:none;">
    <tr>
        
        <td>
             <b><?php echo CHtml::encode($modTerima->getAttributeLabel('nofaktur')); ?></b>
        </td>
        <td>
             : <?php echo CHtml::encode($modTerima->nofaktur); ?>
        </td>
        <td>
             <b><?php echo CHtml::encode($modTerima->getAttributeLabel('nopenerimaanbahan')); ?></b>
        </td>
        <td>
             : <?php echo CHtml::encode($modTerima->nopenerimaanbahan); ?>
        </td>
    </tr>
    <tr>
        <td>
             <b><?php echo CHtml::encode($modTerima->getAttributeLabel('tglfaktur')); ?></b>
        </td>
        <td>
             : <?php echo CHtml::encode($modTerima->tglfaktur); ?>
        </td>
        <td>           
            
             <b><?php echo CHtml::encode($modTerima->getAttributeLabel('tglterimabahan')); ?></b>            
             
        </td>
        <td>
         : <?php echo MyFormatter::formatDateTimeForUser(date("Y-m-d",strtotime(MyFormatter::formatDateTimeForDb(CHtml::encode($modTerima->tglterimabahan))))); ?>

        </td>
        
    </tr>
    <tr>
        <td><b><?php echo CHtml::encode($modTerima->getAttributeLabel('ruangan_id')); ?></b></td>
        <td>: <?php echo CHtml::encode($modTerima->ruangan->ruangan_nama); ?></td>
        
    </tr>    
</table>

<table class="table" style = "box-shadow:none;">
    <thead>
        <tr>
        <th class="border">No.Urut</th>
        <th  class="border">Golongan</th>
        <th  class="border">Jenis</th>
        <th  class="border">Kelompok</th>
        <th  class="border">Nama</th>
       <!--<th>Jumlah Persediaan</th>-->
        <!--<th>Satuan</th>-->
        <th  class="border">Harga Netto</th>
        <th  class="border">Harga Jual</th>
        <th  class="border">Tanggal Kedaluwarsa</th>
        <th  class="border">Jumlah</th>
        <th  class="border">Sub Total</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $totalSubTotal= "";
    $no=1;
        foreach($modDetailTerima AS $tampilData)://$tampilData->nourutbahan
            $subTotal = $tampilData->qty_terima*$tampilData->harganettobhn;//<td style='text-align: right;'>".$tampilData->bahanmakanan->jmlpersediaan."</td>   
    echo "<tr>
            <td class='border'>".$no."</td>
            <td class='border'>".$tampilData->golbahanmakanan->golbahanmakanan_nama."</td>  
            <td class='border'>".$tampilData->bahanmakanan->jenisbahanmakanan."</td>   
            <td class='border'>".$tampilData->bahanmakanan->kelbahanmakanan."</td>   
            <td class='border'>".$tampilData->bahanmakanan->namabahanmakanan."</td>                           
            <td class='border' style='text-align: right;'>Rp".MyFormatter::formatNumberForPrint($tampilData->harganettobhn)."</td>   
            <td class='border' style='text-align: right;'>Rp".MyFormatter::formatNumberForPrint($tampilData->bahanmakanan->hargajualbahan)."</td>   
            <td class='border'>".MyFormatter::formatDateTimeForUser($tampilData->bahanmakanan->tglkadaluarsabahan)."</td>   
            <td class='border' style='text-align: right;'>".number_format($tampilData->qty_terima,2,",",".").' '.$tampilData->satuanbahan."</td>   
            <td class='border' style='text-align: right;'>Rp".  MyFormatter::formatNumberForPrint($subTotal)."</td>     
            
                      
         </tr>";  
        $no++;
        
        $totalSubTotal=$totalSubTotal+$subTotal;
        
        endforeach;
     
    ?>
         <?php
        echo "<tr>
            <td class='border' colspan='9' style='text-align:right;'> <b>Total Harga Netto</b></td>
           
            <td class='border' style='text-align: right;'>Rp".  MyFormatter::formatNumberForPrint($totalSubTotal)."</td>
         </tr>"; 
        
        $totalSubTotal += ($modTerima->biayapengiriman + $modTerima->biayatransportasi + $modTerima->biayapajak - $modTerima->totaldiscount);
        
        echo "<tr>
            <td class='border' colspan='9' style='text-align:right;'> <b>Keringanan</b></td>
           
            <td class='border' style='text-align: right;'>Rp".  MyFormatter::formatNumberForPrint($modTerima->totaldiscount)."</td>
         </tr>";
        echo "<tr>
            <td class='border' colspan='9' style='text-align:right;'> <b>Biaya Pengiriman</b></td>
           
            <td class='border' style='text-align: right;'>Rp".  MyFormatter::formatNumberForPrint($modTerima->biayapengiriman)."</td>
         </tr>";   
        echo "<tr>
            <td class='border' colspan='9' style='text-align:right;'> <b>Biaya Transportasi</b></td>
           
            <td class='border' style='text-align: right;'>Rp".  MyFormatter::formatNumberForPrint($modTerima->biayatransportasi)."</td>
         </tr>";   
        echo "<tr>
            <td class='border' colspan='9' style='text-align:right;'> <b>Biaya Pajak (PPn)</b></td>
           
            <td class='border' style='text-align: right;'>Rp".  MyFormatter::formatNumberForPrint($modTerima->biayapajak)."</td>
         </tr>";   
        echo "<tr>
            <td class='border' colspan='9' style='text-align:right;'> <b>Grand Total</b></td>
           
            <td class='border' style='text-align: right;'>Rp".  MyFormatter::formatNumberForPrint($totalSubTotal)."</td>
         </tr>";  
        
        ?>
   
    </tbody>
    
       
</table>

    <table class ="table" style = "box-shadow:none;">
    <tr>
        <td width="100%" align="left" align="top">
            <table style="width: 100%; border: none;">
                <tr>
                    <td width="35%" align="center">
                        
                    </td>
                    <td width="35%" align="center">
                        
                    </td>
                    <td width="35%" style="text-align:center;">
                       
                        <div>Petugas Penerima</div>
                       
                        <div style="margin-top:60px;"><?php echo isset($modTerima->penerima->pegawai->namaLengkap) ? $modTerima->penerima->pegawai->namaLengkap : "" ?></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    </table>

