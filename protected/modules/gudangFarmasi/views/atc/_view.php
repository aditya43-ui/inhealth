<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('atc_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->atc_id),array('view','id'=>$data->atc_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('atc_kode')); ?>:</b>
	<?php echo CHtml::encode($data->atc_kode); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('atc_nama')); ?>:</b>
	<?php echo CHtml::encode($data->atc_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('atc_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->atc_namalain); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('atc_singkatan')); ?>:</b>
	<?php echo CHtml::encode($data->atc_singkatan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('atc_ddd')); ?>:</b>
	<?php echo CHtml::encode($data->atc_ddd); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('atc_units')); ?>:</b>
	<?php echo CHtml::encode($data->atc_units); ?>
	<br>

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('atc_admr')); ?>:</b>
	<?php echo CHtml::encode($data->atc_admr); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('atc_note')); ?>:</b>
	<?php echo CHtml::encode($data->atc_note); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('atc_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->atc_aktif); ?>
	<br>

	*/ ?>

</div>