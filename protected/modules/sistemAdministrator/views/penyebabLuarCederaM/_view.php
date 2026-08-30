<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('penyebabluarcedera_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->penyebabluarcedera_id),array('view','id'=>$data->penyebabluarcedera_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('penyebabluarcedera_nama')); ?>:</b>
	<?php echo CHtml::encode($data->penyebabluarcedera_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('penyebabluarcedera_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->penyebabluarcedera_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('penyebabluarcedera_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->penyebabluarcedera_aktif); ?>
	<br>

</div>