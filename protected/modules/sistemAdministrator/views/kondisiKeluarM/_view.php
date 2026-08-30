<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('kondisikeluar_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->kondisikeluar_id),array('view','id'=>$data->kondisikeluar_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('carakeluar_id')); ?>:</b>
	<?php echo CHtml::encode($data->carakeluar_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kondisikeluar_nama')); ?>:</b>
	<?php echo CHtml::encode($data->kondisikeluar_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kondisikeluar_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->kondisikeluar_namalain); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kondisikeluar_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->kondisikeluar_aktif); ?>
	<br>

</div>