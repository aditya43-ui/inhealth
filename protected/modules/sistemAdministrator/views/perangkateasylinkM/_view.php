<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('perangkateasylink_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->perangkateasylink_id),array('view','id'=>$data->perangkateasylink_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('perangkateasylink_id')); ?>:</b>
	<?php echo CHtml::encode($data->perangkateasylink_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('perangkat_ip')); ?>:</b>
	<?php echo CHtml::encode($data->perangkat_ip); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('perangkat_port')); ?>:</b>
	<?php echo CHtml::encode($data->perangkat_port); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('perangkat_sn')); ?>:</b>
	<?php echo CHtml::encode($data->perangkat_sn); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_time')); ?>:</b>
	<?php echo CHtml::encode($data->create_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_time')); ?>:</b>
	<?php echo CHtml::encode($data->update_time); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('create_loginpemakai_id')); ?>:</b>
	<?php echo CHtml::encode($data->create_loginpemakai_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_loginpemakai_id')); ?>:</b>
	<?php echo CHtml::encode($data->update_loginpemakai_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_ruangan')); ?>:</b>
	<?php echo CHtml::encode($data->create_ruangan); ?>
	<br />

	*/ ?>

</div>