<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('statuskehadiran_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->statuskehadiran_id),array('view','id'=>$data->statuskehadiran_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('statuskehadiran_nama')); ?>:</b>
	<?php echo CHtml::encode($data->statuskehadiran_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('statuskehadiran_singkatan')); ?>:</b>
	<?php echo CHtml::encode($data->statuskehadiran_singkatan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('statuskehadiran_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->statuskehadiran_aktif); ?>
	<br>

</div>