<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('subkelompok_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->subkelompok_id),array('view','id'=>$data->subkelompok_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelompok_id')); ?>:</b>
	<?php echo CHtml::encode($data->kelompok_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('subkelompok_kode')); ?>:</b>
	<?php echo CHtml::encode($data->subkelompok_kode); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('subkelompok_nama')); ?>:</b>
	<?php echo CHtml::encode($data->subkelompok_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('subkelompok_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->subkelompok_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('subkelompok_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->subkelompok_aktif); ?>
	<br>

</div>