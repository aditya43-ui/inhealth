<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisbarang_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->jenisbarang_id),array('view','id'=>$data->jenisbarang_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisbarang_id')); ?>:</b>
	<?php echo CHtml::encode($data->jenisbarang_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisbarang_nama')); ?>:</b>
	<?php echo CHtml::encode($data->jenisbarang_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisbarang_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->jenisbarang_namalain); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisbarang_deskripsi')); ?>:</b>
	<?php echo CHtml::encode($data->jenisbarang_deskripsi); ?>
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisbarang_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->jenisbarang_aktif); ?>
	<br>

	*/ ?>

</div>