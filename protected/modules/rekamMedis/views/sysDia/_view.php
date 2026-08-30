<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('sysdia_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->sysdia_id),array('view','id'=>$data->sysdia_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelompokumur_id')); ?>:</b>
	<?php echo CHtml::encode($data->kelompokumur_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('systolic_min')); ?>:</b>
	<?php echo CHtml::encode($data->systolic_min); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('systolic_max')); ?>:</b>
	<?php echo CHtml::encode($data->systolic_max); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('diastolic_min')); ?>:</b>
	<?php echo CHtml::encode($data->diastolic_min); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('diastolic_max')); ?>:</b>
	<?php echo CHtml::encode($data->diastolic_max); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('sysdia_range')); ?>:</b>
	<?php echo CHtml::encode($data->sysdia_range); ?>
	<br>

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('sysdia_nama')); ?>:</b>
	<?php echo CHtml::encode($data->sysdia_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('sysdia_desc')); ?>:</b>
	<?php echo CHtml::encode($data->sysdia_desc); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('sysdia_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->sysdia_aktif); ?>
	<br>

	*/ ?>

</div>