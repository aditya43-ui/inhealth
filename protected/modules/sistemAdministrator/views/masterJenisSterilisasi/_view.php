<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenissterilisasi_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->jenissterilisasi_id),array('view','id'=>$data->jenissterilisasi_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenissterilisasi_nama')); ?>:</b>
	<?php echo CHtml::encode($data->jenissterilisasi_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenissterilisasi_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->jenissterilisasi_namalain); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenissterilisasi_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->jenissterilisasi_aktif); ?>
	<br>

</div>