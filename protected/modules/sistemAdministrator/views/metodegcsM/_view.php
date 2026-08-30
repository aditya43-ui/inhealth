<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('metodegcs_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->metodegcs_id),array('view','id'=>$data->metodegcs_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('metodegcs_id')); ?>:</b>
	<?php echo CHtml::encode($data->metodegcs_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('metodegcs_nama')); ?>:</b>
	<?php echo CHtml::encode($data->metodegcs_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('metodegcs_singkatan')); ?>:</b>
	<?php echo CHtml::encode($data->metodegcs_singkatan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('metodegcs_nilai')); ?>:</b>
	<?php echo CHtml::encode($data->metodegcs_nilai); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('metodegcs_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->metodegcs_aktif); ?>
	<br>

</div>