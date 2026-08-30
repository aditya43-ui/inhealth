<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('layanansurvei_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->layanansurvei_id),array('view','id'=>$data->layanansurvei_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('instalasi_id')); ?>:</b>
	<?php echo CHtml::encode($data->instalasi_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('ruangan_id')); ?>:</b>
	<?php echo CHtml::encode($data->ruangan_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('layanansurvei_nama')); ?>:</b>
	<?php echo CHtml::encode($data->layanansurvei_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('layanansurvei_ask')); ?>:</b>
	<?php echo CHtml::encode($data->layanansurvei_ask); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('layanansurvei_desc')); ?>:</b>
	<?php echo CHtml::encode($data->layanansurvei_desc); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('layanansurvei_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->layanansurvei_aktif); ?>
	<br>

</div>