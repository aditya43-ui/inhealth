<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('smsgateway_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->smsgateway_id),array('view','id'=>$data->smsgateway_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('modul_id')); ?>:</b>
	<?php echo CHtml::encode($data->modul_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('tujuansms')); ?>:</b>
	<?php echo CHtml::encode($data->tujuansms); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenissms')); ?>:</b>
	<?php echo CHtml::encode($data->jenissms); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('formatsms')); ?>:</b>
	<?php echo CHtml::encode($data->formatsms); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jmlkaraktersms')); ?>:</b>
	<?php echo CHtml::encode($data->jmlkaraktersms); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('katawalsms')); ?>:</b>
	<?php echo CHtml::encode($data->katawalsms); ?>
	<br>

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('kataakhirsms')); ?>:</b>
	<?php echo CHtml::encode($data->kataakhirsms); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('ishurufkapital')); ?>:</b>
	<?php echo CHtml::encode($data->ishurufkapital); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('modcontroller')); ?>:</b>
	<?php echo CHtml::encode($data->modcontroller); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('modaction')); ?>:</b>
	<?php echo CHtml::encode($data->modaction); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('templatesms')); ?>:</b>
	<?php echo CHtml::encode($data->templatesms); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('statussms')); ?>:</b>
	<?php echo CHtml::encode($data->statussms); ?>
	<br>

	*/ ?>

</div>