<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('subkelas_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->subkelas_id),array('view','id'=>$data->subkelas_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('subkelas_nama')); ?>:</b>
	<?php echo CHtml::encode($data->subkelas_nama); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('subkelas_kode')); ?>:</b>
	<?php echo CHtml::encode($data->subkelas_kode); ?>
	<br />


	<b><?php echo CHtml::encode($data->getAttributeLabel('subkelas_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->subkelas_aktif); ?>
	<br />


</div>