<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('asesmengiziitem_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->asesmengiziitem_id),array('view','id'=>$data->asesmengiziitem_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('asesmengiziitem_id')); ?>:</b>
	<?php echo CHtml::encode($data->asesmengiziitem_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('asesmengiziitem_nama')); ?>:</b>
	<?php echo CHtml::encode($data->asesmengiziitem_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('asesmengiziitem_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->asesmengiziitem_aktif); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_time')); ?>:</b>
	<?php echo CHtml::encode($data->create_time); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_time')); ?>:</b>
	<?php echo CHtml::encode($data->update_time); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_loginpemakai_id')); ?>:</b>
	<?php echo CHtml::encode($data->create_loginpemakai_id); ?>
	<br>

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('update_loginpemakai_id')); ?>:</b>
	<?php echo CHtml::encode($data->update_loginpemakai_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_ruangan')); ?>:</b>
	<?php echo CHtml::encode($data->create_ruangan); ?>
	<br>

	*/ ?>

</div>