<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('statuskepemilikanrumah_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->statuskepemilikanrumah_id), array('view', 'id'=>$data->statuskepemilikanrumah_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('statuskepemilikanrumah_nama')); ?>:</b>
	<?php echo CHtml::encode($data->statuskepemilikanrumah_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('statuskepemilikanrumah_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->statuskepemilikanrumah_namalain); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('statuskepemilikanrumah_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->statuskepemilikanrumah_aktif); ?>
	<br>

</div>