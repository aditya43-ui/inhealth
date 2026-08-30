<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisform_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->jenisform_id),array('view','id'=>$data->jenisform_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisform_nama')); ?>:</b>
	<?php echo CHtml::encode($data->jenisform_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisform_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->jenisform_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisform_kelompok')); ?>:</b>
	<?php echo CHtml::encode($data->jenisform_kelompok); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisform_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->jenisform_aktif); ?>
	<br>

</div>