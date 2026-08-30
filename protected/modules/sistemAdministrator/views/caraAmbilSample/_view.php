<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('samplelab_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->samplelab_id),array('view','id'=>$data->samplelab_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kode_sample')); ?>:</b>
	<?php echo CHtml::encode($data->kode_sample); ?>
	<br>
	<b><?php echo CHtml::encode($data->getAttributeLabel('samblelab_nama')); ?>:</b>
	<?php echo CHtml::encode($data->samblelab_nama); ?>
	<br>
	<b><?php echo CHtml::encode($data->getAttributeLabel('samplelab_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->samplelab_namalainnya); ?>
	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('jeniskegiatanlab_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->jeniskegiatanlab_aktif); ?>
	<br>

	*/ ?>

</div>