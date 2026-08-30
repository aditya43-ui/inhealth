<div class="view">
	<b><?php echo CHtml::encode($data->getAttributeLabel('jenistindakanrm_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->jenistindakanrm_id),array('view','id'=>$data->jenistindakanrm_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenistindakanrm_nama')); ?>:</b>
	<?php echo CHtml::encode($data->jenistindakanrm_nama); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenistindakanrm_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->jenistindakanrm_namalainnya); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenistindakanrm_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->jenistindakanrm_aktif); ?>
	<br />
</div>