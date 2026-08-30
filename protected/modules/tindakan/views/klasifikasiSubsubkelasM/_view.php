<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('klasifikasisubsubkelas_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->klasifikasisubsubkelas_id),array('view','id'=>$data->klasifikasisubsubkelas_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('klasifikasisubsubkelas_nama')); ?>:</b>
	<?php echo CHtml::encode($data->klasifikasisubsubkelas_nama); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('klasifikasisubsubkelas_kode')); ?>:</b>
	<?php echo CHtml::encode($data->klasifikasisubsubkelas_kode); ?>
	<br />


	<b><?php echo CHtml::encode($data->getAttributeLabel('klasifikasisubsubkelas_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->klasifikasisubsubkelas_aktif); ?>
	<br />


</div>