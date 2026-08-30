<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('statusscan_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->statusscan_id),array('view','id'=>$data->statusscan_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('statusscan_nama')); ?>:</b>
	<?php echo CHtml::encode($data->statusscan_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('statusscan_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->statusscan_namalain); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('statusscan_singkatan')); ?>:</b>
	<?php echo CHtml::encode($data->statusscan_singkatan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('statusscan_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->statusscan_aktif); ?>
	<br>

</div>