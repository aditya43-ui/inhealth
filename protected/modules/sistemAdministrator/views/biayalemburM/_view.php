<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('biayalembur_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->biayalembur_id),array('view','id'=>$data->biayalembur_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('biayalembur_nilai')); ?>:</b>
	<?php echo CHtml::encode($data->biayalembur_nilai); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('biayalembur_nilailibur')); ?>:</b>
	<?php echo CHtml::encode($data->biayalembur_nilailibur); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('biayalembur_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->biayalembur_aktif); ?>
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