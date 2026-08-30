<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('resephd_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->resephd_id),array('view','id'=>$data->resephd_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('resephd_id')); ?>:</b>
	<?php echo CHtml::encode($data->resephd_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('resephd_nama')); ?>:</b>
	<?php echo CHtml::encode($data->resephd_nama); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('resephd_desc')); ?>:</b>
	<?php echo CHtml::encode($data->resephd_desc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('resephd_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->resephd_aktif); ?>
	<br />


</div>