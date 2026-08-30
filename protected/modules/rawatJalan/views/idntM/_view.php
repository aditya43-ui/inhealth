<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('idnt_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idnt_id),array('view','id'=>$data->idnt_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idnt_nama')); ?>:</b>
	<?php echo CHtml::encode($data->idnt_nama); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idnt_kode')); ?>:</b>
	<?php echo CHtml::encode($data->idnt_kode); ?>
	<br />


	<b><?php echo CHtml::encode($data->getAttributeLabel('idnt_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->idnt_aktif); ?>
	<br />


</div>