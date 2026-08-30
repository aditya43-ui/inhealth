<tr>
	<td style="text-align: center;width:50px;">
		<?php echo CHtml::textField('nourut','',array('readonly'=>true, 'class'=>'span1'));?>
		<?php echo CHtml::activeHiddenField($model, '[ii]penjamin_nama',array('readonly'=>true));?>
		<?php echo CHtml::activeHiddenField($model, '[ii]jenisobatalkes_nama',array('readonly'=>true));?>
		<?php echo CHtml::activeHiddenField($model, '[ii]hpp_min',array('readonly'=>true));?>
		<?php echo CHtml::activeHiddenField($model, '[ii]hpp_maks',array('readonly'=>true));?>
		<?php echo CHtml::activeHiddenField($model, '[ii]persmargin',array('readonly'=>true));?>
		<?php echo CHtml::activeHiddenField($model, '[ii]persdiskon',array('readonly'=>true));?>
	</td>
	<td>
		<?php echo isset($model->penjamin->penjamin_nama) ? $model->penjamin->penjamin_nama : "-"; ?>	
	</td>
	<td>
		<?php echo isset($model->jenisobatalkes->jenisobatalkes_nama) ? $model->jenisobatalkes->jenisobatalkes_nama : "-"; ?>	
	</td>
	<td>
		<?php echo isset($model->hpp_min) ? $model->hpp_min : "-"; ?>	
	</td>
	<td>
		<?php echo isset($model->hpp_maks) ? $model->hpp_maks : "-"; ?>	
	</td>
	<td>
		<?php echo isset($model->persmargin) ? $model->persmargin : "-"; ?>	
	</td>
	<td>
		<?php echo isset($model->persdiskon) ? $model->persdiskon : "-"; ?>	
	</td>
	<td style="text-align: center;">
		<?php echo CHtml::link("<i class='icon-remove'></i>",'javascript:void(0);',array('onclick'=>'hapusDetail(this);','title'=>'Klik untuk menghapus data ini', 'rel'=>'tooltip')); ?>
	</td>
</tr>
