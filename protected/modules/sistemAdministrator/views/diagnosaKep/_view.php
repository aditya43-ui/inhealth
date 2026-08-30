<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('lookup_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->lookup_id),array('view','id'=>$data->lookup_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lookup_type')); ?>:</b>
	<?php echo CHtml::encode($data->lookup_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lookup_name')); ?>:</b>
	<?php echo CHtml::encode($data->lookup_name); ?>
	<br />
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('lookup_value')); ?>:</b>
	<?php echo CHtml::encode($data->lookup_value); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lookup_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->lookup_aktif); ?>
	<br />


</div>