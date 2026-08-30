<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('pemeriksaanlabdet_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->pemeriksaanlabdet_id),array('view','id'=>$data->pemeriksaanlabdet_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nilairujukan_id')); ?>:</b>
	<?php echo CHtml::encode($data->nilairujukan_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pemeriksaanlab_id')); ?>:</b>
	<?php echo CHtml::encode($data->pemeriksaanlab_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pemeriksaanlabdet_nourut')); ?>:</b>
	<?php echo CHtml::encode($data->pemeriksaanlabdet_nourut); ?>
	<br />


</div>