<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('alatfinger_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->alatfinger_id),array('view','id'=>$data->alatfinger_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('namaalat')); ?>:</b>
	<?php echo CHtml::encode($data->namaalat); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('ipfinger')); ?>:</b>
	<?php echo CHtml::encode($data->ipfinger); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('keyfinger')); ?>:</b>
	<?php echo CHtml::encode($data->keyfinger); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('lokasifinger')); ?>:</b>
	<?php echo CHtml::encode($data->lokasifinger); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('keterangan')); ?>:</b>
	<?php echo CHtml::encode($data->keterangan); ?>
	<br>
	<b><?php echo CHtml::encode($data->getAttributeLabel('alat_aktif')); ?>:</b>
	<?php echo ($data->alat_aktif == true ? 'Aktif' : 'Tidak Aktif'); ?>
	<br>

</div>