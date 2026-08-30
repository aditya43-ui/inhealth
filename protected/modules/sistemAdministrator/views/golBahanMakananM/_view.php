<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('golbahanmakanan_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->golbahanmakanan_id), array('view', 'id'=>$data->golbahanmakanan_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('golbahanmakanan_nama')); ?>:</b>
	<?php echo CHtml::encode($data->golbahanmakanan_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('golbahanmakanan_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->golbahanmakanan_namalain); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('golbahanmakanan_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->golbahanmakanan_aktif); ?>
	<br>

</div>