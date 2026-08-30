<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('penyulit_hd_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->penyulit_hd_id),array('view','id'=>$data->penyulit_hd_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('penyulit_hd_nama')); ?>:</b>
	<?php echo CHtml::encode($data->penyulit_hd_nama); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('penyulit_hd_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->penyulit_hd_namalainnya); ?>
	<br />


</div>