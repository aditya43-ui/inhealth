<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('alatscanwajah_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->alatscanwajah_id),array('view','id'=>$data->alatscanwajah_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('alatscanwajah_id')); ?>:</b>
	<?php echo CHtml::encode($data->alatscanwajah_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_ip')); ?>:</b>
	<?php echo CHtml::encode($data->user_ip); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('alat_ip')); ?>:</b>
	<?php echo CHtml::encode($data->alat_ip); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_time')); ?>:</b>
	<?php echo CHtml::encode($data->create_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_time')); ?>:</b>
	<?php echo CHtml::encode($data->update_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_loginpemakai_id')); ?>:</b>
	<?php echo CHtml::encode($data->create_loginpemakai_id); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('update_loginpemakai_id')); ?>:</b>
	<?php echo CHtml::encode($data->update_loginpemakai_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_ruangan')); ?>:</b>
	<?php echo CHtml::encode($data->create_ruangan); ?>
	<br />

	*/ ?>

</div>