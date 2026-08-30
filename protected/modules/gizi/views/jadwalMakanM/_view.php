<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('jadwalmakan_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->jadwalmakan_id), array('view', 'id'=>$data->jadwalmakan_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jeniswaktu_id')); ?>:</b>
	<?php echo CHtml::encode($data->jeniswaktu_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisdiet_id')); ?>:</b>
	<?php echo CHtml::encode($data->jenisdiet_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipediet_id')); ?>:</b>
	<?php echo CHtml::encode($data->tipediet_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('menudiet_id')); ?>:</b>
	<?php echo CHtml::encode($data->menudiet_id); ?>
	<br>

</div>