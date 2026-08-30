<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('asalrujukan_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->asalrujukan_id),array('view','id'=>$data->asalrujukan_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('asalrujukan_nama')); ?>:</b>
	<?php echo CHtml::encode($data->asalrujukan_nama); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('asalrujukan_institusi')); ?>:</b>
	<?php echo CHtml::encode($data->asalrujukan_institusi); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('asalrujukan_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->asalrujukan_namalainnya); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('asalrujukan_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->asalrujukan_aktif); ?>
	<br />


</div>