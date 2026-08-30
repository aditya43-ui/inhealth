<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('shift_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->shift_id),array('view','id'=>$data->shift_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('shift_nama')); ?>:</b>
	<?php echo CHtml::encode($data->shift_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('shift_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->shift_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('shift_jamawal')); ?>:</b>
	<?php echo CHtml::encode($data->shift_jamawal); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('shift_jamakhir')); ?>:</b>
	<?php echo CHtml::encode($data->shift_jamakhir); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('shift_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->shift_aktif); ?>
	<br>

</div>