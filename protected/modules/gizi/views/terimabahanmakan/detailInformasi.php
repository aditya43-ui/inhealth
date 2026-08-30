<style>
    body {
        color: black;
        /*font-size: 10px;*/
    }
    
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
    
    .tab_header, .tab_detail {
        width:100%;
    }
    
    .tab_detail th {
        text-align: center;
    }
    
    .tab_detail td, .tab_detail th {
        border: 1px solid black;
        padding: 2px;
    }
</style>
<?php  echo $this->renderPartial('application.views.headerReport.headerDefaultNew',array('judulLaporan'=>'DATA PENERIMAAN BAHAN MAKANAN')); ?>
<?php 

$tglUangmuka = "";
$jmlUangmuka = "Rp 0";

$modUangMuka = UangmukabeliT::model()->findByAttributes(array('pengajuanbahanmkn_id'=>$modTerima->pengajuanbahanmkn_id));

if(isset($modUangMuka)){
    $tglUangmuka = MyFormatter::formatDateTimeForUser($modUangMuka->tgluangmukabeli);
    $jmlUangmuka = "Rp ". (!empty($modUangMuka->jumlahuang)?MyFormatter::formatNumberForPrint($modUangMuka->jumlahuang,2):0);
}

?>
<table  class="tab_header" style = "box-shadow:none;" style="width:100%;">
    <tr>
        <td width="50%">
            <table  class="tab_header" style = "box-shadow:none;" style="width:100%;">
                <tr>
                    <td width="200px">No Penerimaan</td>
                    <td>: <?php echo $modTerima->nopenerimaanbahan; ?></td>
                </tr>
                <tr>
                    <td>Tgl. Terima</td>
                    <td>: <?php echo MyFormatter::formatDateTimeForUser($modTerima->tglterimabahan); ?></td>
                </tr>
                <tr>
                    <td>No Surat Jalan</td>
                    <td>: <?php echo $modTerima->nosuratjalan; ?></td>
                </tr>
                <tr>
                    <td>Tgl. Surat Jalan</td>
                    <td>: <?php echo (isset($modTerima->tglsurjalan)? MyFormatter::formatDateTimeForUser($modTerima->tglsurjalan):"-"); ?></td>
                </tr>
                <tr>
                    <td>Supplier</td>
                    <td>: <?php echo (isset($modTerima->supplier)?$modTerima->supplier->supplier_nama : "-"); ?></td>
                </tr>
                <tr>
                    <td>Pegawai Penerima</td>
                    <td>: <?php echo (isset($modTerima->pegawaipenerima)? $modTerima->pegawaipenerima->namaLengkap : "-"); ?></td>
                </tr>
                <tr>
                    <td>Keterangan Penerimaan</td>
                    <td>: <?php echo $modTerima->keterangan_terima_bahan; ?></td>
                </tr>
                <tr>
                    <td>Jenis PPh</td>
                    <td>: <?php echo (isset($modTerima->pajak)?$modTerima->pajak->pajak_nama:""); ?></td>
                </tr>
            </table>
        </td>
        <td width="50%">
            <table  class="tab_header" style = "box-shadow:none;" style="width:100%;">
                <tr>
                    <td width="200px">Tgl. Pembayaran Uang Muka</td>
                    <td>: <?php echo $tglUangmuka; ?></td>
                </tr>
                <tr>
                    <td>Jumlah Uang Muka</td>
                    <td>: <?php echo (Params::cekHiddenHargaGizi()==true) ? $jmlUangmuka : "Hidden"; ?></td>
                </tr>
                <tr>
                    <td>Total Harga</td>
                    <td>: <?php echo (Params::cekHiddenHargaGizi()==true) ? "Rp ". (!empty($modTerima->totalharganetto)?MyFormatter::formatNumberForPrint($modTerima->totalharganetto,2): 0) : "Hidden"; ?></td>
                </tr>
                <tr>
                    <td>Total Keringanan</td>
                    <td>: <?php echo (Params::cekHiddenHargaGizi()==true) ? "Rp ". (!empty($modTerima->totaldiscount)?MyFormatter::formatNumberForPrint($modTerima->totaldiscount,2): 0) : "Hidden"; ?></td>
                </tr>
                <tr>
                    <td>Total PPN</td>
                    <td>: <?php echo (Params::cekHiddenHargaGizi()==true) ? "Rp ". (!empty($modTerima->biayapajak)?MyFormatter::formatNumberForPrint($modTerima->biayapajak,2): 0) : "Hidden"; ?></td>
                </tr>
                <tr>
                    <td>Total PPh</td>
                    <td>: <?php echo (Params::cekHiddenHargaGizi()==true) ? "Rp ". (!empty($modTerima->biayapajakpph)?MyFormatter::formatNumberForPrint($modTerima->biayapajakpph,2): 0) : "Hidden"; ?></td>
                </tr>
                <tr>
                    <td>Total Keseluruhan</td>
                    <td>: <?php echo (Params::cekHiddenHargaGizi()==true) ? "Rp ". (!empty($modTerima->totalkeseluruhan)?MyFormatter::formatNumberForPrint($modTerima->totalkeseluruhan,2): 0) : "Hidden"; ?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<br>
<table class="tab_detail" style = "box-shadow:none;">
    <thead>
        <tr>
        <th class="border">No</th>
        <th class="border">Kelompok</th>
        <th class="border">Nama</th>
        <th class="border">Jumlah Persediaan</th>
        <th class="border">Jumlah Terima</th>
        <th class="border">Tanggal Kedaluwarsa</th>
        <th class="border">Harga Netto (Rp)</th>
        <th class="border">Keringanan (%)</th>
        <th class="border">Keringanan (Rp)</th>
        <th class="border">PPN (%)</th>
        <th class="border">PPN (Rp)</th>
        <th class="border">PPh (%)</th>
        <th class="border">PPh (Rp)</th>
        <th class="border">Subtotal  (Rp)</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $totalSubTotal= 0;
    $totalnetto = 0;
    $totalDiskon = 0;
    $totalPpn = 0;
    $totalPph = 0;
    $no=1;
        foreach($modDetailTerima AS $tampilData):
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
        $persediaan = (isset($tampilData->bahanmakanan)?0: $tampilData->bahanmakanan->jmlpersediaan);
        
    echo "<tr>
            <td class='border'>".$no."</td>
            <td class='border'>".$tampilData->bahanmakanan->kelbahanmakanan."</td>   
            <td class='border'>".$tampilData->bahanmakanan->namabahanmakanan."</td>        
            <td class='border' style='text-align: right;'>".MyFormatter::formatNumberForUser($persediaan)." ".$tampilData->satuanbahan."</td>  
            <td class='border' style='text-align: right;'>".number_format($tampilData->qty_terima,2,",",".").' '.$tampilData->satuanbahan."</td>           
            <td class='border'>".MyFormatter::formatDateTimeForUser($tampilData->bahanmakanan->tglkadaluarsabahan)."</td>      
            <td class='border' style='text-align: right;'>".((Params::cekHiddenHargaGizi()==true) ? "Rp ".number_format($tampilData->harganettobhn,2,",","."):"Hidden")."</td>   
            <td class='border' style='text-align: right;'>".number_format($tampilData->persendiscount,2,",",".")."</td>   
            <td class='border' style='text-align: right;'>".((Params::cekHiddenHargaGizi()==true) ? "Rp ".number_format($jmlDiskon,2,",","."):"Hidden")."</td>   
            <td class='border' style='text-align: right;'>".number_format($tampilData->persenppn)."</td>   
            <td class='border' style='text-align: right;'>".((Params::cekHiddenHargaGizi()==true) ? "Rp ".number_format($jmlPpn,2,",","."):"Hidden")."</td>   
            <td class='border' style='text-align: right;'>".number_format($tampilData->persenpph,2,",",".")."</td>   
            <td class='border' style='text-align: right;'>".((Params::cekHiddenHargaGizi()==true) ? "Rp ".number_format($jmlPph,2,",","."):"Hidden")."</td>   
            <td class='border' style='text-align: right;'>".((Params::cekHiddenHargaGizi()==true) ? "Rp ".  number_format($subTotal,2,",","."):"Hidden")."</td>     
         </tr>";  
        $no++;
        endforeach;
     
    ?>
         <?php
        echo "<tr>
            <td class='border' colspan='13' style='text-align:right;'> <b>Total</b></td>
            <td class='border' style='text-align: right;'>".((Params::cekHiddenHargaGizi()==true) ? "Rp ".  number_format($totalSubTotal,2,",","."):"Hidden")."</td>
         </tr>";
        ?>
   
    </tbody>
    
       
</table>

 <?php
//if (isset($_GET['frame'])){
    
    //echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('EXCEL')")); 
?>
    <script type='text/javascript'>
    /**
     * print
     */    
    function printLagi(caraPrint){
        terimabahanmakan_id = '<?php echo !empty($modTerima->terimabahanmakan_id) ? $modTerima->terimabahanmakan_id : ''; ?>';
        window.open('<?php echo $this->createUrl('printDetailPenerimaan'); ?>&id='+terimabahanmakan_id+'&caraPrint='+caraPrint+'&frame=false','printwin','left=100,top=100,width=1000,height=640');
    }
    </script>
<?php
//}else{ ?>
    <table class ="table" style = "box-shadow:none;">
    <tr>
        <td width="100%" align="left" align="top">
            <table style="width: 100%; border: none;">
                <tr>
                    <td width="35%" align="center">
<!--<div>Petugas Penerima</div>-->
                       
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
<?php //} 
if(isset($_GET['print']) && $_GET['print'] == 1){
    if ($_GET['print']!="PDF"){ 
    echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array());
   } 
}
else {
    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"printLagi('PRINT')"));
}
?>