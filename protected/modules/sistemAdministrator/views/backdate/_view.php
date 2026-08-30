<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('backdate_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->backdate_id),array('view','id'=>$data->backdate_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('backdate_id')); ?>:</b>
	<?php echo CHtml::encode($data->backdate_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modul_id')); ?>:</b>
	<?php echo CHtml::encode($data->modul_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('deskripsi_backdate')); ?>:</b>
	<?php echo CHtml::encode($data->deskripsi_backdate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('isbackdate')); ?>:</b>
	<?php echo CHtml::encode($data->isbackdate); ?>
	<br />


</div>