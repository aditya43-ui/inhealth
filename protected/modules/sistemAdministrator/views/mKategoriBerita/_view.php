<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('mkategoriberita_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->mkategoriberita_id),array('view','id'=>$data->mkategoriberita_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kategoriberita')); ?>:</b>
	<?php echo CHtml::encode($data->kategoriberita); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('ketkategoriberita')); ?>:</b>
	<?php echo CHtml::encode($data->ketkategoriberita); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('urutankategori')); ?>:</b>
	<?php echo CHtml::encode($data->urutankategori); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kategoriberita_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->kategoriberita_aktif); ?>
	<br>

</div>