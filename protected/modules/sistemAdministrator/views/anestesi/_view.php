<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('anastesi_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->anastesi_id),array('view','id'=>$data->anastesi_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('anastesi_id')); ?>:</b>
	<?php echo CHtml::encode($data->anastesi_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisanastesi_id')); ?>:</b>
	<?php echo CHtml::encode($data->jenisanastesi_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('anastesi_nama')); ?>:</b>
	<?php echo CHtml::encode($data->anastesi_nama); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('anastesi_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->anastesi_namalainnya); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('anastesi_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->anastesi_aktif); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('daftartindakan_id')); ?>:</b>
	<?php echo CHtml::encode($data->daftartindakan_id); ?>
	<br />


</div>