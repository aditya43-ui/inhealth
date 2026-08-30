<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('menu_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->menu_id),array('view','id'=>$data->menu_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelmenu_id')); ?>:</b>
	<?php echo CHtml::encode($data->kelompokmenu->kelmenu_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('modul_id')); ?>:</b>
	<?php echo CHtml::encode($data->modulk->modul_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('menu_nama')); ?>:</b>
	<?php echo CHtml::encode($data->menu_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('menu_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->menu_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('menu_key')); ?>:</b>
	<?php echo CHtml::encode($data->menu_key); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('menu_url')); ?>:</b>
	<?php echo CHtml::encode($data->menu_url); ?>
	<br>

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('menu_fungsi')); ?>:</b>
	<?php echo CHtml::encode($data->menu_fungsi); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('menu_urutan')); ?>:</b>
	<?php echo CHtml::encode($data->menu_urutan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('menu_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->menu_aktif); ?>
	<br>

	*/ ?>

</div>