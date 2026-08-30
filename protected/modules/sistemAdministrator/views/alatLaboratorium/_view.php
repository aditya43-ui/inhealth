<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('pemeriksaanlabalat_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->pemeriksaanlabalat_id),array('view','id'=>$data->pemeriksaanlabalat_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('alatmedis_id')); ?>:</b>
	<?php echo CHtml::encode($data->alatmedis_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pemeriksaanlabalat_kode')); ?>:</b>
	<?php echo CHtml::encode($data->pemeriksaanlabalat_kode); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pemeriksaanlabalat_nama')); ?>:</b>
	<?php echo CHtml::encode($data->pemeriksaanlabalat_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pemeriksaanlabalat_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->pemeriksaanlabalat_namalain); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pemeriksaanlabalat_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->pemeriksaanlabalat_aktif); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_time')); ?>:</b>
	<?php echo CHtml::encode($data->create_time); ?>
	<br>

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('update_time')); ?>:</b>
	<?php echo CHtml::encode($data->update_time); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_loginpemakai_id')); ?>:</b>
	<?php echo CHtml::encode($data->create_loginpemakai_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_loginpemakai_id')); ?>:</b>
	<?php echo CHtml::encode($data->update_loginpemakai_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('createruangan')); ?>:</b>
	<?php echo CHtml::encode($data->createruangan); ?>
	<br>

	*/ ?>

</div>