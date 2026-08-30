<?php 

$obatalkes = ObatalkesM::model()->findByPk($det['obatalkes_id']);
if(isset($det['kemasanbesar']) || $det['kemasanbesar'] > 0){
    $jmlkemasan = ($det['kemasanbesar'] * $det['jmlterima']);    
}else{
    $jmlkemasan = $det['jmlterima'];
}

$jmlTotal = round(($det['harganettoper'] * $jmlkemasan),2);
$jmlDiskon = round((($jmlTotal * $det['persendiscount'])/100),2);
$jmlPPn = round(((($jmlTotal - $jmlDiskon) * $det['persenppn'])/100),2);
$jmlPPh = round(((($jmlTotal - $jmlDiskon) * $det['persenpph'])/100),2);

?>
<tr>
    <td>
        <?php echo $i; ?>        
    </td>    
    <td>
        <?php echo $obatalkes->obatalkes_kode; ?></span>
    </td>
	<td>
		<?php echo $det['nobatch']; ?>
	</td>
    <td>
        <?php echo MyFormatter::formatDateTimeForUser($det['tglkadaluarsa']); ?>
    </td>
	<td>
       <?php echo $obatalkes->obatalkes_nama; ?></span>
    </td>
	<td>
		<?php echo $det['kemasanbesar'].' '.(!empty($obatalkes->satuankecil)? $obatalkes->satuankecil->satuankecil_nama : ""); ?>
	</td>    
    <td style="text-align:right;">      
        <?php 
            $satuanobatnama = "";
            if(!empty($det['satuanbesar_id'])){
                $besar = SatuanbesarM::model()->findByPk($det['satuanbesar_id']);
                $satuanobatnama = (isset($besar)?$besar->satuanbesar_nama:"");
            }else{
                $kecil = SatuankecilM::model()->findByPk($det['satuankecil_id']);
                $satuanobatnama = (isset($kecil)?$kecil->satuankecil_nama:"");
            }
        ?>
        <?php echo number_format($det['jmlterima'],2,",",".").' '.$satuanobatnama; ?>
    </td>
    <td style="text-align:right;">        
        <?php 			
		echo (Params::cekHiddenHargaGudangFarmasi()==true)? number_format($det['harganettoper'],2,",","."):"Hidden"; ?>
    </td>
    <td style="text-align:right;">        
        <?php echo number_format($det['persendiscount'],2,",","."); ?>
    </td>  
    <td style="text-align:right;">        
        <?php echo (Params::cekHiddenHargaGudangFarmasi()==true)?number_format($jmlDiskon,2,",","."):"Hidden"; ?>
    </td>
	<td style="text-align:right;">        
		<?php echo $det['persenppn']; ?>
    </td>
    <td style="text-align:right;">        
		<?php echo (Params::cekHiddenHargaGudangFarmasi()==true)?number_format($jmlPPn,2,",","."):"Hidden"; ?>
    </td>
    <td style="text-align:right;">        
		<?php echo number_format($det['persenpph'],2,",","."); ?>
    </td>
    <td style="text-align:right;">        
		<?php echo (Params::cekHiddenHargaGudangFarmasi()==true)?number_format($jmlPPh,2,",","."):"Hidden"; ?>
    </td>
	<td style="text-align:right;">        
		<?php echo (Params::cekHiddenHargaGudangFarmasi()==true)?number_format($det['hargasatuanper'],2,",","."):"Hidden"; ?>
	</td>
    <td style="text-align:right;">        
        <?php echo (Params::cekHiddenHargaGudangFarmasi()==true)?number_format($det['subtotal'],2,",","."):"Hidden"; ?>
    </td>    
</tr>