<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('nilai_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->nilai_id),array('view','id'=>$data->nilai_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('nilai_angkamin')); ?>:</b>
	<?php echo CHtml::encode($data->nilai_angkamin); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('nilai_angkamaks')); ?>:</b>
	<?php echo CHtml::encode($data->nilai_angkamaks); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('nilai_sebutan')); ?>:</b>
	<?php echo CHtml::encode($data->nilai_sebutan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('nilai_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->nilai_aktif); ?>
	<br>

</div>