<div class="view">
	<b><?php echo CHtml::encode($data->getAttributeLabel('rekperiod_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->rekperiod_id),array('view','id'=>$data->rekperiod_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('perideawal')); ?>:</b>
	<?php echo CHtml::encode($data->perideawal); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('sampaidgn')); ?>:</b>
	<?php echo CHtml::encode($data->sampaidgn); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('deskripsi')); ?>:</b>
	<?php echo CHtml::encode($data->deskripsi); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('isclosing')); ?>:</b>
	<?php echo CHtml::encode($data->isclosing); ?>
	<br>
</div>