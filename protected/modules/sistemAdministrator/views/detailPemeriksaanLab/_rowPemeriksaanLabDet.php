<tr>
	<td style="text-align: center;">
		<?php echo CHtml::activeTextField($model, '[ii]pemeriksaanlabdet_nourut',array('readonly'=>true, 'class'=>'span1'));?>
		<?php echo CHtml::activeHiddenField($model, '[ii]pemeriksaanlab_id',array('readonly'=>true));?>
		<?php echo CHtml::activeHiddenField($model, '[ii]pemeriksaanlabdet_id',array('readonly'=>true));?>
		<?php echo CHtml::activeHiddenField($model, '[ii]nilairujukan_id',array('readonly'=>true));?>
	</td>
	<td>
		<?php echo isset($model->nilairujukan->kelkumurhasillab->kelkumurhasillabnama) ? $model->nilairujukan->kelkumurhasillab->kelkumurhasillabnama : "-"; ?>	
	</td>
	<td>
		<?php echo $model->nilairujukan->nilairujukan_jeniskelamin; ?>	
	</td>
	<td>
		<?php echo $model->nilairujukan->namapemeriksaandet; ?>	
	</td>
	<td>
		<?php 
		if(empty($model->pemeriksaanlabdet_id)){
			echo $model->nilairujukan->nilairujukan_nama; 
		}else{
			echo CHtml::link($model->nilairujukan->nilairujukan_nama." <i class='icon-pencil'></i>",'javascript:void(0);',array('onclick'=>'ubahNilaiRujukan(this);','title'=>'Klik untuk mengubah nilai rujukan ini', 'rel'=>'tooltip')); 
		}
		?>
	</td>
	<td>
		<?php echo $model->nilairujukan->nilairujukan_min; ?>	
	</td>
	<td>
		<?php echo $model->nilairujukan->nilairujukan_max; ?>	
	</td>
	<td>
		<?php echo $model->nilairujukan->nilairujukan_satuan; ?>	
	</td>
	<td>
		<?php echo $model->nilairujukan->nilairujukan_metode; ?>	
	</td>
	<td style="text-align: center;">
		<?php echo CHtml::link("<i class='entypo-up'></i>",'javascript:void(0);',array('onclick'=>'pindahKeAtas(this);')); //'title'=>'Klik untuk memindahkan baris ke atas', 'rel'=>'tooltip' << tidak hilang setelah klik?>
		<?php echo CHtml::link("<i class='entypo-down'></i>",'javascript:void(0);',array('onclick'=>'pindahKeBawah(this);')); ?>
	</td>
	<td style="text-align: center;">
		<?php echo CHtml::link("<i class='icon-form-silang'></i>",'javascript:void(0);',array('onclick'=>'hapusDetail(this);','title'=>'Klik untuk menghapus data ini', 'rel'=>'tooltip')); ?>
	</td>
</tr>
