<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('nursestation_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->nursestation_id),array('view','id'=>$data->nursestation_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nursestation_id')); ?>:</b>
	<?php echo CHtml::encode($data->nursestation_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nursestation_nama')); ?>:</b>
	<?php echo CHtml::encode($data->nursestation_nama); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nursestation_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->nursestation_namalain); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nursestation_lokasi')); ?>:</b>
	<?php echo CHtml::encode($data->nursestation_lokasi); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nursestation_telp')); ?>:</b>
	<?php echo CHtml::encode($data->nursestation_telp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nursestation_pj_id')); ?>:</b>
	<?php echo CHtml::encode($data->nursestation_pj_id); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('nursestation_akitf')); ?>:</b>
	<?php echo CHtml::encode($data->nursestation_akitf); ?>
	<br />

	*/ ?>

</div>