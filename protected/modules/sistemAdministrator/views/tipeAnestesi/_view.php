<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('typeanastesi_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->typeanastesi_id),array('view','id'=>$data->typeanastesi_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('typeanastesi_id')); ?>:</b>
	<?php echo CHtml::encode($data->typeanastesi_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('anastesi_id')); ?>:</b>
	<?php echo CHtml::encode($data->anastesi_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('typeanastesi_nama')); ?>:</b>
	<?php echo CHtml::encode($data->typeanastesi_nama); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('typeanastesi_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->typeanastesi_namalain); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('typeanastesi_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->typeanastesi_aktif); ?>
	<br />


</div>