<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisintervensi_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->jenisintervensi_id),array('view','id'=>$data->jenisintervensi_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisintervensi_id')); ?>:</b>
	<?php echo CHtml::encode($data->jenisintervensi_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisintervensi_nama')); ?>:</b>
	<?php echo CHtml::encode($data->jenisintervensi_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisintervensi_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->jenisintervensi_namalain); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisintervensi_kode')); ?>:</b>
	<?php echo CHtml::encode($data->jenisintervensi_kode); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisintervensi_deskripsi')); ?>:</b>
	<?php echo CHtml::encode($data->jenisintervensi_deskripsi); ?>
	<br>

</div>