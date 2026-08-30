<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('pengangkatanpns_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->pengangkatanpns_id),array('view','id'=>$data->pengangkatanpns_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('realisasipns_id')); ?>:</b>
	<?php echo CHtml::encode($data->realisasipns_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('usulanpns_id')); ?>:</b>
	<?php echo CHtml::encode($data->usulanpns_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pegawai_id')); ?>:</b>
	<?php echo CHtml::encode($data->pegawai_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('perspeng_id')); ?>:</b>
	<?php echo CHtml::encode($data->perspeng_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jabatan')); ?>:</b>
	<?php echo CHtml::encode($data->jabatan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pangkat')); ?>:</b>
	<?php echo CHtml::encode($data->pangkat); ?>
	<br>

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('pendidikan')); ?>:</b>
	<?php echo CHtml::encode($data->pendidikan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('keterangan')); ?>:</b>
	<?php echo CHtml::encode($data->keterangan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pimpinannama')); ?>:</b>
	<?php echo CHtml::encode($data->pimpinannama); ?>
	<br>

	*/ ?>

</div>