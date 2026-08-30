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
<center>
<?php  echo $this->renderPartial('_headerPrint');  ?>
</center>
<table class = "table" style = "box-shadow:none;">
    <tr>
        <td>
             <b><?php echo CHtml::encode($modFakturPembelian->getAttributeLabel('nofaktur')); ?>:</b>            
        </td>
        <td>: <?php echo CHtml::encode($modFakturPembelian->nofaktur); ?></td>
        <td>&nbsp;</td>
        <td><b><?php echo CHtml::encode($modFakturPembelian->getAttributeLabel('totharganetto')); ?></b></td>
        <td>: <?php echo "Rp".CHtml::encode(number_format($modFakturPembelian->totharganetto,0,"",".")); ?></td>
    </tr> 
    <tr>
        <td>
             <b><?php echo CHtml::encode($modFakturPembelian->getAttributeLabel('tglfaktur')); ?>:</b>            
        </td>
        <td>: <?php echo MyFormatter::formatDateTimeForUser(CHtml::encode($modFakturPembelian->tglfaktur)); ?></td>
        <td>&nbsp;</td>
        <td><b><?php echo CHtml::encode($modFakturPembelian->getAttributeLabel('jmldiscount')); ?></b></td>
        <td>             
            : <?php echo CHtml::encode($modFakturPembelian->jmldiscount); ?>            
        </td>
    </tr>   
</table>
<hr/>
<table id="tableObatAlkes" class = "table" style = "box-shadow:none;">
    <thead>
    <tr>
        <th class = "border">No.Urut</th>
        <th class = "border">Sumber Dana</th>
        <th class = "border">Kategori/&nbsp;&nbsp;&nbsp;&nbsp;<br/>Nama Obat</th>
        <th class = "border">Satuan Kecil/<br/>Satuan Besar<br/></th>
        <th class = "border">Jumlah Diterima</th>
        <th class = "border">Harga Netto</th>
        <th class = "border">Harga PPN</th>
        <th class = "border">Harga PPH</th>
        <th class = "border">Jumlah Keringanan</th>
        <th class = "border">Harga Satuan</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $no=1;
        $totalJumlahDiterima = 0;
        $totalNetto = 0;
        $totalPPN = 0;
        $totalPPH = 0;
        $totalJumlahDiskon = 0;
        $totalHargaSatuan = 0;
        $hargappn = 0;
        $hargapph = 0;
        $hargappnfaktur = 0;
        $hargapphfaktur = 0;
        if (isset($modFakturPembelianDetails)){
            if (count($modFakturPembelianDetails) > 0){
                foreach($modFakturPembelianDetails AS $tampilData):
                    if($tampilData['persenppnfaktur'] <= 0){
                        $hargappnfaktur = 0;
                    }else{
                        $hargappn = $tampilData['harganettofaktur'] * ($tampilData['persenppnfaktur'] / 100);
                        $hargappnfaktur = $tampilData['harganettofaktur'] + $hargappn;
                    }
                    if($tampilData['persenpphfaktur'] <= 0){
                        $hargapphfaktur = 0;
                    }else{
                        $hargapph = $tampilData['harganettofaktur'] * ($tampilData['persenpphfaktur'] / 100);
                        $hargapphfaktur = $tampilData['harganettofaktur'] + $hargapph;
                    }
                    
                    echo "<tr>
                            <td style = 'text-align:center;' class = 'border'>".$no."</td>
                            <td  class = 'border' >".$tampilData->sumberdana['sumberdana_nama']."</td>  
                            <td  class = 'border'>".$tampilData->obatalkes['obatalkes_kategori']." /<br> ".$tampilData->obatalkes['obatalkes_nama']."</td>   
                            <td  class = 'border'>".$tampilData->satuankecil['satuankecil_nama']." /<br> ".$tampilData->satuanbesar['satuanbesar_nama']."</td>   
                            <td style = 'text-align:right;' class = 'border'>".$tampilData['jmlterima']."</td>
                            <td style = 'text-align:right;' class = 'border'>".number_format($tampilData['harganettofaktur'],0,"",".")."</td>     
                            <td style = 'text-align:right;' class = 'border'>".number_format($hargappnfaktur,0,"",".")."</td>     
                            <td style = 'text-align:right;' class = 'border'>".number_format($hargapphfaktur,0,"",".")."</td> 
                            <td style = 'text-align:right;' class = 'border'>".number_format($tampilData['jmldiscount'],0,"",".")."</td>        
                            <td style = 'text-align:right;' class = 'border'>".number_format($tampilData['hargasatuan'],0,"",".")."</td>      
                         </tr>";  
                        $no++;
                        $totalJumlahDiterima+=$tampilData['jmlterima'];
                        $totalNetto+=$tampilData['harganettofaktur'];
                        $totalPPN+=$hargappnfaktur;
                        $totalPPH+=$hargapphfaktur;
                        $totalJumlahDiskon+=$tampilData['jmldiscount'];
                        $totalHargaSatuan+=$tampilData['hargasatuan'];
                endforeach;
            }
        }
        
    echo "</tbody><tfoot><tr>
            <td style = 'text-align:right;' class = 'border' colspan='4'><b> Total</b></td>
            <td style = 'text-align:right;' class = 'border'><b>".number_format($totalJumlahDiterima,0,"",".")."</b></td>
            <td style = 'text-align:right;' class = 'border'><b>".number_format($totalNetto,0,"",".")."</b></td>
            <td style = 'text-align:right;' class = 'border'><b>".number_format($totalPPN,0,"",".")."</b></td>
            <td style = 'text-align:right;' class = 'border'><b>".number_format($totalPPH,0,"",".")."</b></td>
            <td style = 'text-align:right;' class = 'border'><b>".number_format($totalJumlahDiskon,0,"",".")."</b></td>
            <td style = 'text-align:right;'  class = 'border'><b>".number_format($totalHargaSatuan,0,"",".")."</b></td>
         </tr></tfoot>";    
    ?>
</table>
<?php 
if(!isset($_GET['caraPrint'])){
	echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary-blue', 'type'=>'button','onclick'=>'print(\'PRINT\')'));                 
}  
?> 
<?php if(isset($_GET['caraPrint'])){  ?>
<table width="100%">
    <tr> 
		<td>&nbsp;</td>
        <td align="center" width="30%"><?php echo Yii::app()->user->getState('kabupaten_nama').", ".date('d M Y'); ?></td>
    </tr>
    <tr>
		<td class="tandatangan">Penerima Faktur</td>
		<td class="tandatangan">Petugas Keuangan</td>
    </tr><tr><td>&nbsp;</td><td>&nbsp;</td></tr>
    <tr>
        <td class="tandatangan" style="height: 50px;">.........................</td>
        <td class="tandatangan" ><?php echo Yii::app()->user->getState('nama_pegawai'); ?>
    </td></tr>
</table><br/><br/>
            <div style="font-size: 9pt;">&nbsp;&nbsp;&nbsp;Print Date : 
    <?php echo date('d M Y H:i:s'); ?></div>
</td></tr></table>
<?php } ?>
<script>
function print(caraPrint)
{
    var pembelianbarang_id = '<?php echo isset($modFakturPembelian->fakturpembelian_id) ? $modFakturPembelian->fakturpembelian_id : null ?>';
    window.open('<?php echo $this->createUrl('detailsFaktur'); ?>&idFakturPembelian='+pembelianbarang_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}	
</script>