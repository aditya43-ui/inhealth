<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisketunaan_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->jenisketunaan_id),array('view','id'=>$data->jenisketunaan_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisketunaan_kode')); ?>:</b>
	<?php echo CHtml::encode($data->jenisketunaan_kode); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisketunaan_nama')); ?>:</b>
	<?php echo CHtml::encode($data->jenisketunaan_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisketunaan_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->jenisketunaan_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisketunaan_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->jenisketunaan_aktif); ?>
	<br>

</div>