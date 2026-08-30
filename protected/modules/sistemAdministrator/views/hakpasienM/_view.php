<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('hakpasien_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->hakpasien_id),array('view','id'=>$data->hakpasien_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hakpasien_id')); ?>:</b>
	<?php echo CHtml::encode($data->hakpasien_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hakpasien_nama')); ?>:</b>
	<?php echo CHtml::encode($data->hakpasien_nama); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hakpasien_urutan')); ?>:</b>
	<?php echo CHtml::encode($data->hakpasien_urutan); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hakpasien_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->hakpasien_aktif); ?>
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