<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('shift_hd_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->shift_hd_id),array('view','id'=>$data->shift_hd_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('shift_hd_id')); ?>:</b>
	<?php echo CHtml::encode($data->shift_hd_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('shift_hd_nama')); ?>:</b>
	<?php echo CHtml::encode($data->shift_hd_nama); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('shift_hd_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->shift_hd_namalainnya); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('shift_hd_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->shift_hd_aktif); ?>
	<br />


</div>