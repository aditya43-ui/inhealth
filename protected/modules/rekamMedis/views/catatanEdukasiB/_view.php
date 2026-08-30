<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('alatmedis_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->alatmedis_id),array('view','id'=>$data->alatmedis_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('instalasi_id')); ?>:</b>
	<?php echo CHtml::encode($data->instalasi_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisalatmedis_id')); ?>:</b>
	<?php echo CHtml::encode($data->jenisalatmedis_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('alatmedis_noaset')); ?>:</b>
	<?php echo CHtml::encode($data->alatmedis_noaset); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('alatmedis_nama')); ?>:</b>
	<?php echo CHtml::encode($data->alatmedis_nama); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('alatmedis_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->alatmedis_namalain); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('alatmedis_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->alatmedis_aktif); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('alatmedis_kode')); ?>:</b>
	<?php echo CHtml::encode($data->alatmedis_kode); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('alatmedis_format')); ?>:</b>
	<?php echo CHtml::encode($data->alatmedis_format); ?>
	<br />

	*/ ?>

</div>