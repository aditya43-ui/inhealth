<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('keluhananamnesis_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->keluhananamnesis_id),array('view','id'=>$data->keluhananamnesis_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('keluhananamnesis_nama')); ?>:</b>
	<?php echo CHtml::encode($data->keluhananamnesis_nama); ?>
	<br>

</div>