<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelompokmodul_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->kelompokmodul_id),array('view','id'=>$data->kelompokmodul_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelompokmodul_nama')); ?>:</b>
	<?php echo CHtml::encode($data->kelompokmodul_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelompokmodul_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->kelompokmodul_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelompokmodul_fungsi')); ?>:</b>
	<?php echo CHtml::encode($data->kelompokmodul_fungsi); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelompokmodul_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->kelompokmodul_aktif); ?>
	<br>

</div>