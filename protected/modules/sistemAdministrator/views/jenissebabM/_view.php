<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenissebab_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->jenissebab_id),array('view','id'=>$data->jenissebab_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenissebab_nama')); ?>:</b>
	<?php echo CHtml::encode($data->jenissebab_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenissebab_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->jenissebab_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenissebab_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->jenissebab_aktif); ?>
	<br>

</div>