<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('harilibur_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->harilibur_id),array('view','id'=>$data->harilibur_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('tglharilibur')); ?>:</b>
	<?php echo CHtml::encode($data->tglharilibur); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('namaharilibur')); ?>:</b>
	<?php echo CHtml::encode($data->namaharilibur); ?>
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_loginpemakai_id')); ?>:</b>
	<?php echo CHtml::encode($data->update_loginpemakai_id); ?>
	<br>

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('create_ruangan')); ?>:</b>
	<?php echo CHtml::encode($data->create_ruangan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('harilibur_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->harilibur_aktif); ?>
	<br>

	*/ ?>

</div>