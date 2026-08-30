<?php 
if(count((array)$modKarcisV) > 0){ 
	echo '<table width="100%" class="table table-bordered">';
	echo "<thead>";
	echo "<th>Karcis</th>";
	echo "<th>Harga (Rp)</th>";
	echo "<th hidden>Pilih</th>";
	echo "</thead>";
	foreach($modKarcisV AS $i =>$karcis){
		$modTindakan->attributes = $karcis->attributes;
		$modTindakan->karcis_id = $karcis->karcis_id;
		$modTindakan->jenistarif_id = $karcis->jenistarif_id;
		$modTindakan->tarif_satuan = $format->formatNumberForUser($karcis->harga_tariftindakan);
		if ($i == 0 ){
			$modTindakan->is_pilihtindakan = 1;
			echo	'<tr class="checked">';
			$icon = 'icon-form-silang';
		}else{
			$modTindakan->is_pilihtindakan = 0;
			echo	'<tr class="">';
			$icon = 'icon-form-check';
		}

		echo '	<td>'.CHtml::label($karcis['karcis_nama'],$karcis['karcis_nama']).'</td>
				<td style="text-align:right;">'.CHtml::activeTextField($modTindakan, '['.$i.']tarif_satuan',array('readonly'=>true, 'class'=>'span1 integer', 'style'=>'width:96px;text-align:right;')).'</td>
				<td hidden><a data-karcis="'.$karcis['karcis_id'].'"id="selectPasien" class="btn-small" href="javascript:void(0);" onclick="pilihKarcis(this); return false;">
					<i class="'.$icon.'"></i>
					</a>'
				.CHtml::activeHiddenField($modTindakan, '['.$i.']is_pilihtindakan',array('readonly'=>true, 'class'=>'span1'))  
				.CHtml::activeHiddenField($modTindakan, '['.$i.']daftartindakan_id',array('readonly'=>true, 'class'=>'span1'))  
				.CHtml::activeHiddenField($modTindakan, '['.$i.']karcis_id',array('readonly'=>true, 'class'=>'span1'))
				.CHtml::activeHiddenField($modTindakan, '['.$i.']jenistarif_id',array('readonly'=>true, 'class'=>'span1'))
			.'</td>'
			.'</tr>';
		}
	echo "</table>";
}

?>
<!--<div class="control-group"> //fitur belum ada >> RND-666
    <div class="controls">
    <?php // echo $form->checkBox($model,'is_bayarkarcis',array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
    <?php // echo CHtml::label('Karcis Dibayar Langsung', 'is_bayarkarcis') ?>
    </div>
</div>-->

