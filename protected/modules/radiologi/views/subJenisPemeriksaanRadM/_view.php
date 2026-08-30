<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('pemeriksaanrad_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->pemeriksaanrad_id),array('view','id'=>$data->pemeriksaanrad_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('daftartindakan_id')); ?>:</b>
	<?php echo CHtml::encode($data->daftartindakan_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pemeriksaanrad_jenis')); ?>:</b>
	<?php echo CHtml::encode($data->pemeriksaanrad_jenis); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pemeriksaanrad_nama')); ?>:</b>
	<?php echo CHtml::encode($data->pemeriksaanrad_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pemeriksaanrad_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->pemeriksaanrad_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pemeriksaanrad_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->pemeriksaanrad_aktif); ?>
	<br>

</div>