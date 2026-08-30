<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelompokpegawai_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->kelompokpegawai_id),array('view','id'=>$data->kelompokpegawai_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelompokpegawai_nama')); ?>:</b>
	<?php echo CHtml::encode($data->kelompokpegawai_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelompokpegawai_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->kelompokpegawai_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelompokpegawai_fungsi')); ?>:</b>
	<?php echo CHtml::encode($data->kelompokpegawai_fungsi); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelompokpegawai_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->kelompokpegawai_aktif); ?>
	<br>

</div>