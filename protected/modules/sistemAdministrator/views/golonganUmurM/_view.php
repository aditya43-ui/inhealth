<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('golonganumur_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->golonganumur_id),array('view','id'=>$data->golonganumur_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('golonganumur_nama')); ?>:</b>
	<?php echo CHtml::encode($data->golonganumur_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('golonganumur_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->golonganumur_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('golonganumur_minimal')); ?>:</b>
	<?php echo CHtml::encode($data->golonganumur_minimal); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('golonganumur_maksimal')); ?>:</b>
	<?php echo CHtml::encode($data->golonganumur_maksimal); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('golonganumur_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->golonganumur_aktif); ?>
	<br>

</div>