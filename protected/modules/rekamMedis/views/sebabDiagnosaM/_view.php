<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('sebabdiagnosa_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->sebabdiagnosa_id),array('view','id'=>$data->sebabdiagnosa_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenissebab_id')); ?>:</b>
	<?php echo CHtml::encode($data->jenissebab_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('sebabdiagnosa_nama')); ?>:</b>
	<?php echo CHtml::encode($data->sebabdiagnosa_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('sebabdiagnosa_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->sebabdiagnosa_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('sebabdiagnosa_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->sebabdiagnosa_aktif); ?>
	<br>

</div>