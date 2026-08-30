<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('komponenunit_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->komponenunit_id),array('view','id'=>$data->komponenunit_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('komponenunit_nama')); ?>:</b>
	<?php echo CHtml::encode($data->komponenunit_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('komponenunit_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->komponenunit_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('komponenunit_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->komponenunit_aktif); ?>
	<br>

</div>