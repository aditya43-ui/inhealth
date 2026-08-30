<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('pendkualifikasi_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->pendkualifikasi_id),array('view','id'=>$data->pendkualifikasi_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pendkualifikasi_kode')); ?>:</b>
	<?php echo CHtml::encode($data->pendkualifikasi_kode); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pendkualifikasi_nama')); ?>:</b>
	<?php echo CHtml::encode($data->pendkualifikasi_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pendkualifikasi_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->pendkualifikasi_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pendkualifikasi_keterangan')); ?>:</b>
	<?php echo CHtml::encode($data->pendkualifikasi_keterangan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pendkualifikasi_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->pendkualifikasi_aktif); ?>
	<br>

</div>