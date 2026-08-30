<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('detailnapza_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->detailnapza_id),array('view','id'=>$data->detailnapza_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('napza_id')); ?>:</b>
	<?php echo CHtml::encode($data->napza_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('detailnapza_nama')); ?>:</b>
	<?php echo CHtml::encode($data->detailnapza_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('detailnapza_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->detailnapza_namalain); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('detailnapza_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->detailnapza_aktif); ?>
	<br>

</div>