<tr>
	<td colspan="2" style="text-align: right">Total Penyusutan</td>
	<td><?php echo $format->formatUang($total_penyusutan); ?>
		<?php echo CHtml::activeHiddenField($model,'totalpenyusutan',array('readonly'=>true,'value'=>$total_penyusutan)); ?></td>
</tr>