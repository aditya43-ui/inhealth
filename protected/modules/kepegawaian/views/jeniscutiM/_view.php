<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('jeniscuti_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->jeniscuti_id),array('view','id'=>$data->jeniscuti_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jeniscuti_id')); ?>:</b>
	<?php echo CHtml::encode($data->jeniscuti_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jeniscuti_nama')); ?>:</b>
	<?php echo CHtml::encode($data->jeniscuti_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jeniscuti_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->jeniscuti_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jeniscuti_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->jeniscuti_aktif); ?>
	<br>

</div>