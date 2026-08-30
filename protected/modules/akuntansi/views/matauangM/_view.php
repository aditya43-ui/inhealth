<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('matauang_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->matauang_id),array('view','id'=>$data->matauang_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('matauang')); ?>:</b>
	<?php echo CHtml::encode($data->matauang); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('singkatan')); ?>:</b>
	<?php echo CHtml::encode($data->singkatan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('matauang_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->matauang_aktif); ?>
	<br>

</div>