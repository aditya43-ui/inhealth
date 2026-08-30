<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenishd_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->jenishd_id),array('view','id'=>$data->jenishd_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenishd_id')); ?>:</b>
	<?php echo CHtml::encode($data->jenishd_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenishd_nama')); ?>:</b>
	<?php echo CHtml::encode($data->jenishd_nama); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenishd_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->jenishd_namalain); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenishd_deskripsi')); ?>:</b>
	<?php echo CHtml::encode($data->jenishd_deskripsi); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenishd_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->jenishd_aktif); ?>
	<br />


</div>