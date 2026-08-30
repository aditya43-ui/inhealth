<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('keadaanumum_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->keadaanumum_id),array('view','id'=>$data->keadaanumum_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('keadaanumum_nama')); ?>:</b>
	<?php echo CHtml::encode($data->keadaanumum_nama); ?>
	<br>

</div>