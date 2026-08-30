<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('golongan_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->golongan_id),array('view','id'=>$data->golongan_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('golongan_kode')); ?>:</b>
	<?php echo CHtml::encode($data->golongan_kode); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('golongan_nama')); ?>:</b>
	<?php echo CHtml::encode($data->golongan_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('golongan_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->golongan_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('golongan_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->golongan_aktif); ?>
	<br>

</div>