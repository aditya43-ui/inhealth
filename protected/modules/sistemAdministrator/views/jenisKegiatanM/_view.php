<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('jeniskegiatan_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->jeniskegiatan_id),array('view','id'=>$data->jeniskegiatan_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jeniskegiatan_kode')); ?>:</b>
	<?php echo CHtml::encode($data->jeniskegiatan_kode); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jeniskegiatan_nama')); ?>:</b>
	<?php echo CHtml::encode($data->jeniskegiatan_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jeniskegiatan_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->jeniskegiatan_aktif); ?>
	<br>

</div>