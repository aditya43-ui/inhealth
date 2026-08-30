<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('sumberanggaran_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->sumberanggaran_id),array('view','id'=>$data->sumberanggaran_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kodesumberanggaran')); ?>:</b>
	<?php echo CHtml::encode($data->kodesumberanggaran); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('sumberanggarannama')); ?>:</b>
	<?php echo CHtml::encode($data->sumberanggarannama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('sumberanggarannamalain')); ?>:</b>
	<?php echo CHtml::encode($data->sumberanggarannamalain); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('sumberanggaran_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->sumberanggaran_aktif); ?>
	<br>

</div>