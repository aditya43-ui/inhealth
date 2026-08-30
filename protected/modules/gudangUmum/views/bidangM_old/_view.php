<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('bidang_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->bidang_id),array('view','id'=>$data->bidang_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('subkelompok_id')); ?>:</b>
	<?php echo CHtml::encode($data->subkelompok_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('bidang_kode')); ?>:</b>
	<?php echo CHtml::encode($data->bidang_kode); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('bidang_nama')); ?>:</b>
	<?php echo CHtml::encode($data->bidang_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('bidang_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->bidang_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('bidang_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->bidang_aktif); ?>
	<br>

</div>