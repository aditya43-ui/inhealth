<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('morfologineoplasma_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->morfologineoplasma_id),array('view','id'=>$data->morfologineoplasma_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('morfologineoplasma_nama')); ?>:</b>
	<?php echo CHtml::encode($data->morfologineoplasma_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('morfologineoplasma_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->morfologineoplasma_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('morfologineoplasma_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->morfologineoplasma_aktif); ?>
	<br>

</div>