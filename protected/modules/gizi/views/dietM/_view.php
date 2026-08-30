<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('diet_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->diet_id), array('view', 'id'=>$data->diet_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipediet_id')); ?>:</b>
	<?php echo CHtml::encode($data->tipediet_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('zatgizi_id')); ?>:</b>
	<?php echo CHtml::encode($data->zatgizi_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisdiet_id')); ?>:</b>
	<?php echo CHtml::encode($data->jenisdiet_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('diet_kandungan')); ?>:</b>
	<?php echo CHtml::encode($data->diet_kandungan); ?>
	<br>

</div>