<?php 
if (count((array)$modDetailBeli)>0){
	$ii = 1;
    foreach ($modDetailBeli as $i => $detail) {       
                $totalHpp = number_format(($detail->jmlterima * $detail->hargasatuan),2,",",".");
		$detail->harganettoubah = $detail->harganettofaktur;
		$detail->persendiscount = number_format($detail->persendiscount,2,",","");
//		$detail->subtotal = number_format((($detail->hargasatuan*$detail->jmlterima)-$detail->jmldiscount),2,",",".");
        ?>
        <tr>
			<td>
				<?php echo $ii; ?>
			</td>
            <td>
                <?php echo $detail->obatalkes->obatalkes_nama; ?>
            </td>
            <td style="text-align: right;">
                <?php echo MyFormatter::formatNumberForPrint($detail->jmlterima).' '.$detail->obatalkes->satuankecil->satuankecil_nama; ?>				
            </td>
            <td style="text-align: right;">
                <?php 
				if (CustomFunction::isDecimal($detail->harganettofaktur)){
					echo MyFormatter::formatNumberForPrint($detail->harganettofaktur,2); 
				}else{
					echo MyFormatter::formatNumberForPrint($detail->harganettofaktur); 
				}
				?>				
            </td>
            <td style="text-align: right;" hidden>
                <?php echo $detail->persendiscount; ?>
            </td>
            <td style="text-align: right;">
                <?php 
					if (CustomFunction::isDecimal($detail->jmldiscount)){
						echo MyFormatter::formatNumberForPrint($detail->jmldiscount,2); 
					}else{
						echo MyFormatter::formatNumberForPrint($detail->jmldiscount); 
					}
				?>
            </td>
            <td style="text-align: right;">
                <?php echo MyFormatter::formatNumberForPrint($detail->persenppnfaktur); ?>
            </td>
             <td style="text-align: right;">
                <?php echo MyFormatter::formatNumberForPrint($detail->persenpphfaktur); ?>
            </td>
            <td style="text-align: right;" hidden>
                <?php echo MyFormatter::formatNumberForPrint($detail->persendiscount); ?>
            </td>
            <td style="text-align: right;">
                <?php
				if (CustomFunction::isDecimal($detail->hargasatuan)){					
					echo MyFormatter::formatNumberForPrint($detail->hargasatuan,2); 
				}else{
					echo MyFormatter::formatNumberForPrint($detail->hargasatuan); 
				}
				?>
            </td>
            <td style="text-align: right;">
                <?php 				
                                if (CustomFunction::isDecimal($detail->hargasatuan)){					
					echo MyFormatter::formatNumberForPrint($detail->hargasatuan,2); 
				}else{
					echo MyFormatter::formatNumberForPrint($detail->hargasatuan); 
				}
				?>
            </td>
<!--<td style="text-align: right;">
                <?php 				
//					echo ($totalHpp); 
				?>
            </td>-->
        </tr>
    <?php 
	$ii++;
    }
}
?>

