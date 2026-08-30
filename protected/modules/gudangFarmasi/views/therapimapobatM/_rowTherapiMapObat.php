<tr>
	<td style="text-align: center;">
		<?php echo CHtml::activeTextField($model, '[ii]no_urut',array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
		<?php echo CHtml::activeHiddenField($model, '[ii]obatalkes_id',array('readonly'=>true));?>
		<?php echo CHtml::activeHiddenField($model, '[ii]therapiobat_id',array('readonly'=>true));?>
		<?php echo CHtml::activeHiddenField($model, '[ii]kosong',array('readonly'=>true));?>
	</td>
	<td>
		<?php echo $model->therapiobat->therapiobat_nama; ?>	
	</td>
	<td>
		<?php echo $model->obatalkes->obatalkes_nama; ?>	
	</td>
	<td style="text-align: center;">
		<?php echo CHtml::link("<i style='font-size:16px' class='fa fa-arrow-up'></i>",'javascript:void(0);',array('onclick'=>'pindahKeAtas(this);')); //'title'=>'Klik untuk memindahkan baris ke atas', 'rel'=>'tooltip' << tidak hilang setelah klik?>
		<?php echo CHtml::link("<i style='font-size:16px' class='fa fa-arrow-down'></i>",'javascript:void(0);',array('onclick'=>'pindahKeBawah(this);')); ?>
	</td>
	<td style="text-align: center;">
		<?php echo CHtml::link("<i class='icon-form-silang'></i>",'javascript:void(0);',array('onclick'=>'hapusDetail(this);','title'=>'Klik untuk menghapus data ini', 'rel'=>'tooltip')); ?>
	</td>
</tr>
