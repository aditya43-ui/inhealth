<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisanastesi_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->jenisanastesi_id),array('view','id'=>$data->jenisanastesi_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisanastesi_id')); ?>:</b>
	<?php echo CHtml::encode($data->jenisanastesi_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisanastesi_nama')); ?>:</b>
	<?php echo CHtml::encode($data->jenisanastesi_nama); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisanastesi_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->jenisanastesi_namalainnya); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisanastesi_teknik')); ?>:</b>
	<?php echo CHtml::encode($data->jenisanastesi_teknik); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisanastesi_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->jenisanastesi_aktif); ?>
	<br />


</div>