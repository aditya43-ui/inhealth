<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('pengumuman_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->pengumuman_id),array('view','id'=>$data->pengumuman_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('judul')); ?>:</b>
	<?php echo CHtml::encode($data->judul); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('isi')); ?>:</b>
	<?php echo CHtml::encode($data->isi); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('status_publish')); ?>:</b>
	<?php echo CHtml::encode($data->status_publish); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_loginpemakai_id')); ?>:</b>
	<?php echo CHtml::encode($data->create_loginpemakai_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_time')); ?>:</b>
	<?php echo CHtml::encode($data->create_time); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_loginpemakai_id')); ?>:</b>
	<?php echo CHtml::encode($data->update_loginpemakai_id); ?>
	<br>

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('update_time')); ?>:</b>
	<?php echo CHtml::encode($data->update_time); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('publish_loginpemakai_id')); ?>:</b>
	<?php echo CHtml::encode($data->publish_loginpemakai_id); ?>
	<br>

	*/ ?>

</div>