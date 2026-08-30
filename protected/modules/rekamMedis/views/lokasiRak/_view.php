<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('lokasirak_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->lokasirak_id),array('view','id'=>$data->lokasirak_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('lokasirak_nama')); ?>:</b>
	<?php echo CHtml::encode($data->lokasirak_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('lokasirak_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->lokasirak_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('lokasirak_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->lokasirak_aktif); ?>
	<br>

</div>