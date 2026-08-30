<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenissurat_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->jenissurat_id), array('view', 'id'=>$data->jenissurat_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenissurat_nama')); ?>:</b>
	<?php echo CHtml::encode($data->jenissurat_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenissurat_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->jenissurat_namalain); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenissurat_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->jenissurat_aktif); ?>
	<br>

</div>