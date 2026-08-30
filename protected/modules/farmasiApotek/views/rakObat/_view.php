<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('rakobat_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->rakobat_id),array('view','id'=>$data->rakobat_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('rakobat_nama')); ?>:</b>
	<?php echo CHtml::encode($data->rakobat_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('rakobat_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->rakobat_namalain); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('rakobat_label')); ?>:</b>
	<?php echo CHtml::encode($data->rakobat_label); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('rakobat_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->rakobat_aktif); ?>
	<br>

</div>