<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisskriningpasien_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->jenisskriningpasien_id),array('view','id'=>$data->jenisskriningpasien_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisskriningpasien_id')); ?>:</b>
	<?php echo CHtml::encode($data->jenisskriningpasien_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisskriningpasien_nama')); ?>:</b>
	<?php echo CHtml::encode($data->jenisskriningpasien_nama); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisskriningpasien_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->jenisskriningpasien_namalainnya); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('isaktif')); ?>:</b>
	<?php echo CHtml::encode($data->isaktif); ?>
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