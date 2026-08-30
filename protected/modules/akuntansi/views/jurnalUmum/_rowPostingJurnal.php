<tr>
	<td>
		<?php echo $form->hiddenField($modDetail,'[i]jurnaldetail_id',array('class'=>'span2')); ?>
		<?php echo isset($modDetail->jurnalRekening->tglbuktijurnal) ? MyFormatter::formatDateTimeForUser($modDetail->jurnalRekening->tglbuktijurnal) : "-"; ?></td>
	<td><?php echo isset($modDetail->jurnalRekening->kodejurnal) ? $modDetail->jurnalRekening->kodejurnal : "-"; ?></td>
	<td><?php echo isset($modDetail->jurnalRekening->nobuktijurnal) ? $modDetail->jurnalRekening->nobuktijurnal : "-"; ?></td>
	<td>
		<?php echo isset($modDetail->jurnalRekening->tglreferensi) ? $modDetail->jurnalRekening->tglreferensi : "-"; ?><br>
		<?php echo isset($modDetail->jurnalRekening->noreferensi) ? $modDetail->jurnalRekening->noreferensi : "-"; ?>
	</td>
	<td>
		<?php echo ($modDetail->getNamaRekDebit() == "-" ?  $modDetail->getNamaRekKredit() : $modDetail->getNamaRekDebit())?>
	</td>
        <?php
        $modDetail->saldodebit = MyFormatter::formatNumberForPrint($modDetail->saldodebit);
        $modDetail->saldokredit = MyFormatter::formatNumberForPrint($modDetail->saldokredit);
        ?>
	<td><?php echo $form->textField($modDetail,'[i]saldodebit',array('class'=>'span2 integer2','readonly'=>true)); ?></td>
	<td><?php echo $form->textField($modDetail,'[i]saldokredit',array('class'=>'span2 integer2 ','readonly'=>true)); ?></td>
</tr>