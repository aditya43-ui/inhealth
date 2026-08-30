<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('subloket_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->subloket_id),array('view','id'=>$data->subloket_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('subloket_id')); ?>:</b>
	<?php echo CHtml::encode($data->subloket_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('loket_id')); ?>:</b>
	<?php echo CHtml::encode($data->loket_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('subloket_nama')); ?>:</b>
	<?php echo CHtml::encode($data->subloket_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('subloket_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->subloket_namalain); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('subloket_singkatan')); ?>:</b>
	<?php echo CHtml::encode($data->subloket_singkatan); ?>
	<br>

</div>