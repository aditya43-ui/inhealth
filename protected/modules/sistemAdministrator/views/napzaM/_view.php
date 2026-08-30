<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('napza_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->napza_id),array('view','id'=>$data->napza_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisnapza_id')); ?>:</b>
	<?php echo CHtml::encode($data->jenisnapza_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('napza_nama')); ?>:</b>
	<?php echo CHtml::encode($data->napza_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('napza_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->napza_namalain); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('napza_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->napza_aktif); ?>
	<br>

</div>