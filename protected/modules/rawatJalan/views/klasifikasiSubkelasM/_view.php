<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('klasifikasisubkelas_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->klasifikasisubkelas_id),array('view','id'=>$data->klasifikasisubkelas_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('klasifikasisubkelas_nama')); ?>:</b>
	<?php echo CHtml::encode($data->klasifikasisubkelas_nama); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('klasifikasisubkelas_kode')); ?>:</b>
	<?php echo CHtml::encode($data->klasifikasisubkelas_kode); ?>
	<br />


	<b><?php echo CHtml::encode($data->getAttributeLabel('klasifikasisubkelas_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->klasifikasisubkelas_aktif); ?>
	<br />


</div>