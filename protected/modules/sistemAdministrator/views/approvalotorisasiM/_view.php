<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('approvalotorisasi_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->approvalotorisasi_id),array('view','id'=>$data->approvalotorisasi_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kepalagizi_id')); ?>:</b>
	<?php echo CHtml::encode($data->kepalagizi_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kepalafarmasi_id')); ?>:</b>
	<?php echo CHtml::encode($data->kepalafarmasi_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kepalaumum_id')); ?>:</b>
	<?php echo CHtml::encode($data->kepalaumum_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kasipersonalia_id')); ?>:</b>
	<?php echo CHtml::encode($data->kasipersonalia_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('managerumum_id')); ?>:</b>
	<?php echo CHtml::encode($data->managerumum_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('managerkeuangan_id')); ?>:</b>
	<?php echo CHtml::encode($data->managerkeuangan_id); ?>
	<br>

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('direkturrs_id')); ?>:</b>
	<?php echo CHtml::encode($data->direkturrs_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('direkturpt_id')); ?>:</b>
	<?php echo CHtml::encode($data->direkturpt_id); ?>
	<br>

	*/ ?>

</div>