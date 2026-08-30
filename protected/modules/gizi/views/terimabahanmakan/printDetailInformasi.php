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
<table style="width: 100%; border: none;">
    <thead>
        <tr>
             <td>
                <div class="header"><?php
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNew',array('judulLaporan'=>'DATA PENERIMAAN BAHAN MAKANAN'));
                    ?></div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
			<div class="judulcontent">  </div>
                        <table  class="table" style = "box-shadow:none;">
    <tr>
        <td>
             <b><?php echo CHtml::encode($modTerima->getAttributeLabel('nopenerimaanbahan')); ?></b>
        </td>
        <td>
             : <?php echo CHtml::encode($modTerima->nopenerimaanbahan); ?>
        </td>
        <td>&nbsp;</td>
        <td><b><?php echo CHtml::encode($modTerima->getAttributeLabel('ruangan_id')); ?></b></td>
        <td>: <?php echo CHtml::encode($modTerima->ruangan->ruangan_nama); ?></td>
    </tr>
    <tr>
        <td>           
            
             <b><?php echo CHtml::encode($modTerima->getAttributeLabel('tglterimabahan')); ?></b>            
             
        </td>
        <td>
         : <?php echo MyFormatter::formatDateTimeForUser(date("Y-m-d",strtotime(MyFormatter::formatDateTimeForDb(CHtml::encode($modTerima->tglterimabahan))))); ?>

        </td>
    </tr>   
</table>

<table class="table" style = "box-shadow:none;">
    <thead>
        <tr>
        <th class="border">No.Urut</th>
<!--<th  class="border">Golongan</th>
        <th  class="border">Jenis</th>-->
        <th  class="border">Kelompok</th>
        <th  class="border">Nama</th>
       <!--<th>Jumlah Persediaan</th>-->
        <!--<th>Satuan</th>-->
        <th  class="border">Harga Netto</th>
        <!--<th  class="border">Harga Jual</th>-->
        <th  class="border">Tanggal Kedaluwarsa</th>
        <th  class="border">Jumlah</th>
        <th  class="border">Sub Total</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $totalSubTotal= "";
    $totalnetto = 0;
    $totalDiskon = 0;
    $totalPpn = 0;
    $totalPph = 0;
    $no=1;
        foreach($modDetailTerima AS $tampilData)://$tampilData->nourutbahan
            $jmlHarga = round(($tampilData->qty_terima * $tampilData->harganettobhn),2);
            $jmlDiskon = round((($jmlHarga * $tampilData->persendiscount)/100),2);
            $jmlPpn = round(((($jmlHarga - $jmlDiskon) * $tampilData->persenppn)/100),2);
            $jmlPph = round(((($jmlHarga - $jmlDiskon) * $tampilData->persenpph)/100),2);
            
        $subTotal = ($jmlHarga - $jmlDiskon + $jmlPpn - $jmlPph);
        $totalSubTotal+=$subTotal;
        $totalnetto += $tampilData->harganettobhn;
        $totalDiskon += $jmlDiskon;
        $totalPpn += $jmlPpn;
        $totalPph += $jmlPph;
        
     echo "<tr>
            <td class='border'>".$no."</td>
            <td class='border' hidden>".$tampilData->golbahanmakanan->golbahanmakanan_nama."</td>  
            <td class='border' hidden>".$tampilData->bahanmakanan->jenisbahanmakanan."</td>   
            <td class='border'>".$tampilData->bahanmakanan->kelbahanmakanan."</td>   
            <td class='border'>".$tampilData->bahanmakanan->namabahanmakanan."</td>                           
            <td class='border' style='text-align: right;'>".((Params::cekHiddenHargaGizi()==true) ? "Rp ".number_format($tampilData->harganettobhn,2,",","."):"Hidden")."</td>   
            <td class='border' style='text-align: right;' hidden>Rp ".number_format($tampilData->bahanmakanan->hargajualbahan,2,",",".")."</td>   
            <td class='border'>".MyFormatter::formatDateTimeForUser($tampilData->bahanmakanan->tglkadaluarsabahan)."</td>   
            <td class='border' style='text-align: right;'>".number_format($tampilData->qty_terima,2,",",".").' '.$tampilData->satuanbahan."</td>   
            <td class='border' style='text-align: right;'>".((Params::cekHiddenHargaGizi()==true) ? "Rp ".  number_format($subTotal,2,",","."):"Hidden")."</td>     
            
                      
         </tr>";   
        $no++;
        
        
        
        endforeach;
     
    ?>
        <?php
        echo "<tr>
            <td class='border' colspan='6' style='text-align:right;'> <b>Total Harga Netto</b></td>
           
            <td class='border' style='text-align: right;'>".((Params::cekHiddenHargaGizi()==true) ? "Rp ".  number_format($totalnetto,2,",","."):"Hidden")."</td>
         </tr>";
        
//        $totalSubTotal += ($modTerima->biayapengiriman + $modTerima->biayatransportasi + $modTerima->biayapajak - $modTerima->totaldiscount);
        
        echo "<tr>
            <td class='border' colspan='6' style='text-align:right;'> <b>Keringanan</b></td>
           
            <td class='border' style='text-align: right;'>".((Params::cekHiddenHargaGizi()==true) ? "Rp ".  number_format($totalDiskon,2,",","."):"Hidden")."</td>
         </tr>";
        echo "<tr hidden>
            <td class='border' colspan='6' style='text-align:right;'> <b>Biaya Pengiriman</b></td>
           
            <td class='border' style='text-align: right;'>Rp ".  number_format($modTerima->biayapengiriman,2,",",".")."</td>
         </tr>";   
        echo "<tr hidden>
            <td class='border' colspan='6' style='text-align:right;'> <b>Biaya Transportasi</b></td>
           
            <td class='border' style='text-align: right;'>Rp ".  number_format($modTerima->biayatransportasi,2,",",".")."</td>
         </tr>";   
        echo "<tr>
            <td class='border' colspan='6' style='text-align:right;'> <b>Total Pajak (PPn)</b></td>
           
            <td class='border' style='text-align: right;'>".((Params::cekHiddenHargaGizi()==true) ? "Rp ".  number_format($totalPpn,2,",","."):"Hidden")."</td>
         </tr>";  
        echo "<tr>
            <td class='border' colspan='6' style='text-align:right;'> <b>Total Pajak (PPh)</b></td>
           
            <td class='border' style='text-align: right;'>".((Params::cekHiddenHargaGizi()==true) ? "Rp ".  number_format($totalPph,2,",","."):"Hidden")."</td>
         </tr>"; 
        echo "<tr>
            <td class='border' colspan='6' style='text-align:right;'> <b>Sub Total</b></td>
           
            <td class='border' style='text-align: right;'>".((Params::cekHiddenHargaGizi()==true) ? "Rp ".  number_format($totalSubTotal,2,",","."):"Hidden")."</td>
         </tr>";   
        ?>
   
    </tbody>
    
       
</table>

    <table class ="table" style = "box-shadow:none;">
    <tr>
        <td width="100%" align="left" align="top">
            <table width="100%">
                <tr>
                    <td width="35%" align="center">
<!--                        <div>Petugas Penerima</div>-->
                       
                        <!--<div style="margin-top:60px;"><?php // echo isset($modTerima->penerima->pegawai->namaLengkap) ? $modTerima->penerima->pegawai->namaLengkap : "" ?></div>-->
                    </td>
                    <td width="35%" align="center">
                        
                    </td>
                    <td width="35%" style="text-align:center;">
                        <div><?php echo Yii::app()->user->getState("kabupaten_nama").", ".date('d').' '.MyFormatter::getMonthId(date('m')).' '.date('Y'); ?></div>
                        <div>Yang Mengetahui,</div>
                       
                        <div style="margin-top:60px;"><?php echo isset($modTerima->mengetahui_id) ? $modTerima->mengetahui->namaLengkap : "" ?></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    </table>
		</div>		
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td>
                <div class="footer-space">&nbsp;</div>
            </td>
        </tr>
    </tfoot>
</table>
<div class="">
</div>
<div class="footer">
    <?php   if (isset($caraPrint) && $caraPrint!="PDF"){  ?>
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
    <?php  }  ?>
</div>