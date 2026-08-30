<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipediet_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->tipediet_id), array('view', 'id'=>$data->tipediet_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipediet_nama')); ?>:</b>
	<?php echo CHtml::encode($data->tipediet_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipediet_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->tipediet_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipediet_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->tipediet_aktif); ?>
	<br>

</div>