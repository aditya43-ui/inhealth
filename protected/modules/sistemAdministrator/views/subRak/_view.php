<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('subrak_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->subrak_id),array('view','id'=>$data->subrak_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('subrak_nama')); ?>:</b>
	<?php echo CHtml::encode($data->subrak_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('subrak_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->subrak_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('subrak_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->subrak_aktif); ?>
	<br>

</div>