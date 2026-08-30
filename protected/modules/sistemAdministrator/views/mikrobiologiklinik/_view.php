<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('antibiotikmikro_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->antibiotikmikro_id),array('view','id'=>$data->antibiotikmikro_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('antibiotikmikro_kode')); ?>:</b>
	<?php echo CHtml::encode($data->antibiotikmikro_kode); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('antibiotikmikro_nama')); ?>:</b>
	<?php echo CHtml::encode($data->antibiotikmikro_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('antibiotikmikro_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->antibiotikmikro_namalain); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('antibiotikmikro_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->antibiotikmikro_aktif); ?>
	<br>

</div>