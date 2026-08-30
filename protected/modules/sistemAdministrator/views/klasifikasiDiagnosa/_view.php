<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('klasifikasidiagnosa_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->klasifikasidiagnosa_id),array('view','id'=>$data->klasifikasidiagnosa_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('klasifikasidiagnosa_kode')); ?>:</b>
	<?php echo CHtml::encode($data->klasifikasidiagnosa_kode); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('klasifikasidiagnosa_nama')); ?>:</b>
	<?php echo CHtml::encode($data->klasifikasidiagnosa_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('klasifikasidiagnosa_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->klasifikasidiagnosa_namalain); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('klasifikasidiagnosa_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->klasifikasidiagnosa_aktif); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('klasifikasidiagnosa_desc')); ?>:</b>
	<?php echo CHtml::encode($data->klasifikasidiagnosa_desc); ?>
	<br>

</div>