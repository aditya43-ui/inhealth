<?php foreach($modRekenings AS $i => $modRekening){ ?>
<tr>
	<td><?php 
		echo $i+1;
		echo CHtml::activeHiddenField($modSaldoAwal,'['.$i.']rekperiod_id',array('readonly'=>true,'value'=>$modRekening->periodeposting->rekperiode_id)); 	
		echo CHtml::activeHiddenField($modSaldoAwal,'['.$i.']periodeposting_id',array('readonly'=>true,'value'=>$modRekening->periodeposting_id)); 
		?></td>
	<td><?php 
	$kode = '';
//	if(isset($modRekening->rekening1_id))
//	{
//		$kode .= $modRekening->rekening1->kdrekening1;
//		echo CHtml::activeHiddenField($modSaldoAwal,'['.$i.']rekening1_id',array('readonly'=>true,'value'=>$modRekening->rekening1_id));
//		if(isset($modRekening->rekening2_id))
//		{
//			$kode .= '-' . $modRekening->rekening2->kdrekening2;
//			echo CHtml::activeHiddenField($modSaldoAwal,'['.$i.']rekening2_id',array('readonly'=>true,'value'=>$modRekening->rekening2_id));
//			if(isset($modRekening->rekening3_id))
//			{
//				$kode .= '-' . $modRekening->rekening3->kdrekening3;
//				echo CHtml::activeHiddenField($modSaldoAwal,'['.$i.']rekening3_id',array('readonly'=>true,'value'=>$modRekening->rekening3_id));
//				if(isset($modRekening->rekening4_id))
//				{
//					$kode .= '-' . $modRekening->rekening4->kdrekening4;
//					echo CHtml::activeHiddenField($modSaldoAwal,'['.$i.']rekening4_id',array('readonly'=>true,'value'=>$modRekening->rekening4_id));
					if(isset($modRekening->rekening5_id))
					{
						$kode .= $modRekening->rekening5->kdrekening5;
						echo CHtml::activeHiddenField($modSaldoAwal,'['.$i.']rekening5_id',array('readonly'=>true,'value'=>$modRekening->rekening5_id));
					}
//				}
//			}
//		}
//	}
	echo $kode;
	?></td>
	<td><?php 
	if ($modRekening->rekening5_id){
		echo $modRekening->rekening5->nmrekening5;
	}  
	?></td>
	<td style="text-align: right;"><?php echo empty($modRekening->saldodebit) ? "0,00" : $format->formatNumberForPrint($modRekening->saldodebit, 2); ?><?php echo CHtml::activeHiddenField($modSaldoAwal,'['.$i.']jmlsaldoawald',array('readonly'=>true, 'class'=>'debit', 'value'=>$modRekening->saldodebit)); ?></td>
	<td style="text-align: right;"><?php echo empty($modRekening->saldokredit) ? "0,00" : $format->formatNumberForPrint($modRekening->saldokredit, 2); ?><?php echo CHtml::activeHiddenField($modSaldoAwal,'['.$i.']jmlsaldoawalk',array('readonly'=>true, 'class'=>'kredit', 'value'=>$modRekening->saldokredit)); ?></td>
</tr>
<?php } ?>


