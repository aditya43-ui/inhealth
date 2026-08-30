<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('etilogi_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->etilogi_id),array('view','id'=>$data->etilogi_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('etilogi_id')); ?>:</b>
	<?php echo CHtml::encode($data->etilogi_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('etilogi_kode')); ?>:</b>
	<?php echo CHtml::encode($data->etilogi_kode); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('etilogi_nama')); ?>:</b>
	<?php echo CHtml::encode($data->etilogi_nama); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('etilogi_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->etilogi_namalain); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('etilogi_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->etilogi_aktif); ?>
	<br />


</div>