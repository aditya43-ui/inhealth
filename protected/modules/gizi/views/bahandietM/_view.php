<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('bahandiet_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->bahandiet_id), array('view', 'id'=>$data->bahandiet_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('bahandiet_nama')); ?>:</b>
	<?php echo CHtml::encode($data->bahandiet_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('bahandiet_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->bahandiet_namalain); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('bahandiet_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->bahandiet_aktif); ?>
	<br>

</div>