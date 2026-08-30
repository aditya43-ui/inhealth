<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('formasishift_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->formasishift_id),array('view','id'=>$data->formasishift_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('formasishift_id')); ?>:</b>
	<?php echo CHtml::encode($data->formasishift_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('ruangan_id')); ?>:</b>
	<?php echo CHtml::encode($data->ruangan_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('shift_id')); ?>:</b>
	<?php echo CHtml::encode($data->shift_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jmlformasi')); ?>:</b>
	<?php echo CHtml::encode($data->jmlformasi); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_time')); ?>:</b>
	<?php echo CHtml::encode($data->create_time); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_time')); ?>:</b>
	<?php echo CHtml::encode($data->update_time); ?>
	<br>

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('create_loginpemakai_id')); ?>:</b>
	<?php echo CHtml::encode($data->create_loginpemakai_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_loginpemakai_id')); ?>:</b>
	<?php echo CHtml::encode($data->update_loginpemakai_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_ruangan')); ?>:</b>
	<?php echo CHtml::encode($data->create_ruangan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('formasishift_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->formasishift_aktif); ?>
	<br>

	*/ ?>

</div>