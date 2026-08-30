<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelompok_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->kelompok_id),array('view','id'=>$data->kelompok_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('bidang_id')); ?>:</b>
	<?php echo CHtml::encode($data->bidang_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelompok_kode')); ?>:</b>
	<?php echo CHtml::encode($data->kelompok_kode); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelompok_nama')); ?>:</b>
	<?php echo CHtml::encode($data->kelompok_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelompok_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->kelompok_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelompok_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->kelompok_aktif); ?>
	<br>

</div>