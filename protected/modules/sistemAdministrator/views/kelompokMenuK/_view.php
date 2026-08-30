<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelmenu_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->kelmenu_id),array('view','id'=>$data->kelmenu_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelmenu_nama')); ?>:</b>
	<?php echo CHtml::encode($data->kelmenu_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelmenu_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->kelmenu_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelmenu_key')); ?>:</b>
	<?php echo CHtml::encode($data->kelmenu_key); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelmenu_url')); ?>:</b>
	<?php echo CHtml::encode($data->kelmenu_url); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelmenu_urutan')); ?>:</b>
	<?php echo CHtml::encode($data->kelmenu_urutan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelmenu_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->kelmenu_aktif); ?>
	<br>

</div>