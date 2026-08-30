<?php

$listPenjamin = array();
if (!empty($jasaFarmasi->carabayar_id)) {
	$listPenjamin = CHtml::listData(PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$jasaFarmasi->carabayar_id), array('order'=>'penjamin_nama asc')), 'penjamin_id', 'penjamin_nama');
}

// if (!empty($jasaFarmasi->tarif_jasa)) {
// 	$jasaFarmasi->tarif_jasa = MyFormatter::formatNumberForPrint($jasaFarmasi->tarif_jasa, 2);
// }

?>

<tr>
	<td>
		<?php echo CHtml::hiddenField('jasaFarmasi[i][jasafarmasi_id]', $jasaFarmasi->jasafarmasi_id, array('class'=>'jasafarmasi_id')); ?>
		<?php echo CHtml::hiddenField('jasaFarmasi[i][is_delete]', 0, array('class'=>'is_delete')); ?>
		<?php echo CHtml::dropDownList('jasaFarmasi[i][instalasi_id]', $jasaFarmasi->instalasi_id, CHtml::listData(
		InstalasiM::model()->findAll('instalasi_aktif = true and revenuecenter = true and instalasirujukaninternal = false order by instalasi_nama'), 'instalasi_id', 'instalasi_nama'
		), array('empty'=>'-- Pilih --', 'class'=>'instalasi_id', 'style'=>'max-width: 140px;')); ?>
	</td>
	<td>
		<?php echo CHtml::dropDownList('jasaFarmasi[i][carabayar_id]', $jasaFarmasi->carabayar_id, 
			CHtml::listData(CarabayarM::model()->getCarabayarItems(), 'carabayar_id', 'carabayar_nama'), 
			array('empty'=>'-- Pilih --', 'class'=>'carabayar_id', 'style'=>'max-width: 140px;', 'onchange'=>'setPenjamin(this);')); ?>
	</td>
	<td>
		<?php echo CHtml::dropDownList('jasaFarmasi[i][penjamin_id]', $jasaFarmasi->penjamin_id, 
			$listPenjamin, array('empty'=>'-- Pilih --', 'class'=>'penjamin_id', 'style'=>'max-width: 140px;')); ?>
		
	</td>
	<td>
		<?php echo CHtml::textField('jasaFarmasi[i][tarif_jasa]', $jasaFarmasi->tarif_jasa, array('class'=>'integer-decimal tarif_jasa jasa_input', 'style'=>'max-width: 120px;')); ?>
	</td>
	<td><?php echo CHtml::htmlButton('<i class="icon-minus icon-white"></i>', array(
			'class'=>'btn btn-danger removes',
			'onclick'=>'hapusItemJasaFarmasi(this)',
		)); 
		?>
	</td>
		
</tr>

