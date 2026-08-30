<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('hasilpemeriksaanmikro_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->hasilpemeriksaanmikro_id),array('view','id'=>$data->hasilpemeriksaanmikro_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelompok_mikroorganisme')); ?>:</b>
	<?php echo CHtml::encode($data->kelompok_mikroorganisme); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('hasilpemeriksaan')); ?>:</b>
	<?php echo CHtml::encode($data->hasilpemeriksaan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('hasilpemeriksaan_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->hasilpemeriksaan_aktif); ?>
	<br>

</div>