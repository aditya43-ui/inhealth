<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisin_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->jenisin_id),array('view','id'=>$data->jenisin_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisin_nama')); ?>:</b>
	<?php echo CHtml::encode($data->jenisin_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisin_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->jenisin_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisin_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->jenisin_aktif); ?>
	<br>

</div>