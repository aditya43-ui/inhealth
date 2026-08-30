<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisdiklat_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->jenisdiklat_id),array('view','id'=>$data->jenisdiklat_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisdiklat_nama')); ?>:</b>
	<?php echo CHtml::encode($data->jenisdiklat_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisdiklat_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->jenisdiklat_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisdiklat_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->jenisdiklat_aktif); ?>
	<br>

</div>