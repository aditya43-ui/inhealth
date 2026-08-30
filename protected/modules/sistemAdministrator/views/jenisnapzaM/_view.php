<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisnapza_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->jenisnapza_id),array('view','id'=>$data->jenisnapza_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisnapza_nama')); ?>:</b>
	<?php echo CHtml::encode($data->jenisnapza_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisnapza_desc')); ?>:</b>
	<?php echo CHtml::encode($data->jenisnapza_desc); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisnapza_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->jenisnapza_aktif); ?>
	<br>

</div>