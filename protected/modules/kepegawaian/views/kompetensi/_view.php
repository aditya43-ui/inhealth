<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('kompetensi_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->kompetensi_id),array('view','id'=>$data->kompetensi_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kompetensi_nama')); ?>:</b>
	<?php echo CHtml::encode($data->kompetensi_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kompetensi_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->kompetensi_namalain); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kompetensi_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->kompetensi_aktif); ?>
	<br>

</div>