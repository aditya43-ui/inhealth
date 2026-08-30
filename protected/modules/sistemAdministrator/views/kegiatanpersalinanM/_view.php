<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('kegiatanpersalinan_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->kegiatanpersalinan_id),array('view','id'=>$data->kegiatanpersalinan_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kegiatanpersalinan_nama')); ?>:</b>
	<?php echo CHtml::encode($data->kegiatanpersalinan_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kegiatanpersalinan_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->kegiatanpersalinan_namalain); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kegiatanpersalinan_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->kegiatanpersalinan_aktif); ?>
	<br>

</div>