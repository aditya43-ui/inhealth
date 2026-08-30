<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('zatmenudiet_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->zatmenudiet_id), array('view', 'id'=>$data->zatmenudiet_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('zatgizi_id')); ?>:</b>
	<?php echo CHtml::encode($data->zatgizi_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('menudiet_id')); ?>:</b>
	<?php echo CHtml::encode($data->menudiet_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kandunganmenudiet')); ?>:</b>
	<?php echo CHtml::encode($data->kandunganmenudiet); ?>
	<br>

</div>