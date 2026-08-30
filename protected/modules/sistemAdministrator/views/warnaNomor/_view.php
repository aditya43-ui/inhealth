<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('warnanomorrm_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->warnanomorrm_id),array('view','id'=>$data->warnanomorrm_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('warnanomorrm_angka')); ?>:</b>
	<?php echo CHtml::encode($data->warnanomorrm_angka); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('warnanomorrm_warna')); ?>:</b>
	<?php echo CHtml::encode($data->warnanomorrm_warna); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('warnanomorrm_kodewarna')); ?>:</b>
	<?php echo CHtml::encode($data->warnanomorrm_kodewarna); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('warnanomorrm_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->warnanomorrm_aktif); ?>
	<br>

</div>