<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('bodymassindex_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->bodymassindex_id),array('view','id'=>$data->bodymassindex_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('bmi_range')); ?>:</b>
	<?php echo CHtml::encode($data->bmi_range); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('bmi_minimum')); ?>:</b>
	<?php echo CHtml::encode($data->bmi_minimum); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('bmi_maksimum')); ?>:</b>
	<?php echo CHtml::encode($data->bmi_maksimum); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('bmi_sign')); ?>:</b>
	<?php echo CHtml::encode($data->bmi_sign); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('bmi_defenisi')); ?>:</b>
	<?php echo CHtml::encode($data->bmi_defenisi); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('bmi_pesan')); ?>:</b>
	<?php echo CHtml::encode($data->bmi_pesan); ?>
	<br>

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('bodymassindex_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->bodymassindex_aktif); ?>
	<br>

	*/ ?>

</div>