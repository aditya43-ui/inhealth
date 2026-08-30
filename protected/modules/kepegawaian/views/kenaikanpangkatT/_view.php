<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('kenaikanpangkat_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->kenaikanpangkat_id),array('view','id'=>$data->kenaikanpangkat_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('realisasikenaikangaji_id')); ?>:</b>
	<?php echo CHtml::encode($data->realisasikenaikangaji_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('usulankenaikangaji_id')); ?>:</b>
	<?php echo CHtml::encode($data->usulankenaikangaji_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pegawai_id')); ?>:</b>
	<?php echo CHtml::encode($data->pegawai_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jabatan')); ?>:</b>
	<?php echo CHtml::encode($data->jabatan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pangkat')); ?>:</b>
	<?php echo CHtml::encode($data->pangkat); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('keterangan')); ?>:</b>
	<?php echo CHtml::encode($data->keterangan); ?>
	<br>

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('pimpinannama')); ?>:</b>
	<?php echo CHtml::encode($data->pimpinannama); ?>
	<br>

	*/ ?>

</div>