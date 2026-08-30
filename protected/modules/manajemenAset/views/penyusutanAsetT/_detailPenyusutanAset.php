<?php 
$total_penyusutan = 0;
for ($i=1; $i <= $total_bulan; $i++){ 
$tglguna  = strtotime('+'.$i.' month',strtotime($tgl_guna));
$tglguna  = date('Y-m-d', $tglguna);
$tglGuna  = $format->formatMonthForUser($tglguna);		
?>
	<tr>
		<td width="3%"><?php echo $i; ?><?php echo CHtml::activeHiddenField($modDetail,'['.$i.']penyusutanaset_urutan',array('readonly'=>true,'value'=>$i)); ?></td>
		<td><?php echo $tglGuna; ?><?php echo CHtml::activeHiddenField($modDetail,'['.$i.']penyusutanaset_periode',array('readonly'=>true,'value'=>$tglguna)); ?></td>
		<td><?php echo $format->formatUang($saldo_penyusutan); ?><?php echo CHtml::activeHiddenField($modDetail,'['.$i.']penyusutanaset_saldo',array('readonly'=>true,'value'=>$saldo_penyusutan)); ?></td>
	</tr>
<?php } ?>