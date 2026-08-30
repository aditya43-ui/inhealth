<?php
if(!empty($modKarcisAll) && count((array)$modKarcisAll) > 0){
	echo '<table width="100%" class="table table-bordered">';
	echo "<thead>";
	echo "<th>Karcis</th>";
	echo "<th>Harga</th>";
	echo "<th>Pilih</th>";
	echo "</thead>";
	foreach($modKarcisAll AS $i =>$karcis){
		$modTindakan->attributes = $karcis->attributes;
		$modTindakan->karcis_id = $karcis->karcis_id;
		$modTindakan->jenistarif_id = $karcis->jenistarif_id;
		$modTindakan->tarif_satuan = $format->formatNumberForUser($karcis->harga_tariftindakan);
        $is_ada = false;
        foreach ($modKarcisV as $ada) {
            if ($ada->daftartindakan_id == $karcis->daftartindakan_id) {
                $is_ada = true;
            }
        }
        
		if ($is_ada){
			$modTindakan->is_pilihtindakan = 1;
			echo	'<tr class="checked">';
			$icon = 'icon-form-check';
		}else{
			$modTindakan->is_pilihtindakan = 0;
			echo	'<tr class="">';
			$icon = 'icon-form-silang';
		}

		echo '	<td>'.CHtml::label($karcis['karcis_nama'],$karcis['karcis_nama']).'</td>
				<td style="text-align:right;">'.CHtml::activeTextField($modTindakan, '['.$i.']tarif_satuan',array('readonly'=>true, 'class'=>'span1 integer', 'style'=>'width:96px;text-align:right;')).'</td>
				<td><a data-karcis="'.$karcis['karcis_id'].'"id="selectPasien" class="btn-small" href="javascript:void(0);" onclick="pilihKarcis(this); return false;">
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

