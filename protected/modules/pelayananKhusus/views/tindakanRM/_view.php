<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('tindakanrm_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->tindakanrm_id),array('view','id'=>$data->tindakanrm_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenistindakanrm_id')); ?>:</b>
	<?php echo CHtml::encode($data->jenistindakanrm_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('daftartindakan_id')); ?>:</b>
	<?php echo CHtml::encode($data->daftartindakan_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tindakanrm_nama')); ?>:</b>
	<?php echo CHtml::encode($data->tindakanrm_nama); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tindakanrm_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->tindakanrm_namalainnya); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tindakanrm_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->tindakanrm_aktif); ?>
	<br />


</div>