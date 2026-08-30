<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisjurnal_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->jenisjurnal_id),array('view','id'=>$data->jenisjurnal_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisjurnal_nama')); ?>:</b>
	<?php echo CHtml::encode($data->jenisjurnal_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisjurnal_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->jenisjurnal_namalain); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisjurnal_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->jenisjurnal_aktif); ?>
	<br>

</div>