<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('sebabin_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->sebabin_id),array('view','id'=>$data->sebabin_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('sebabin_nama')); ?>:</b>
	<?php echo CHtml::encode($data->sebabin_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('sebabin_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->sebabin_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('sebabin_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->sebabin_aktif); ?>
	<br>

</div>