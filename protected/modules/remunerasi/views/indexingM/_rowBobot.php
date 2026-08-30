<?php

$nama = "";
$bobot = "";

$offset = empty($offset)?0:$offset;
$step = empty($step)?0:$step;
$totbobot = empty($totbobot)?1:$totbobot;

if (!empty($det)) {
	$nama = $det->indexingdef_nama;
	$bobot = $det->bobot;
}

?>

<tr>
	<td>
		<?php echo CHtml::hiddenField('detail[nama_bobot][]', $nama, array('class'=>'subbobot_nama')); ?>
		<?php echo CHtml::hiddenField('detail[nilai_bobot][]', $bobot, array('class'=>'subbobot_nilai')); ?>
		<span class="lb"><?php echo $nama; ?></span>
	</td>
	<td class="sp_nilai" style="text-align: right;"><?php echo $bobot; ?></td>
	<td style="text-align: right;">
		<?php echo CHtml::textField('detail[nilai][]', MyFormatter::formatNumberForPrint($offset + ($step * ($bobot/$totbobot)), 2), 
				array('class'=>'span2 integer2 subbobot_total'
		)); ?>
	</td>
	<td style="text-align: center;">
		<?php echo CHtml::link('<i class="icon-form-silang"></i>', "", array(
			'onclick'=>'removeBobot(this)',
		)); ?>
	</td>
</tr>