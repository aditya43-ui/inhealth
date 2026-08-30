<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('lokasiobat_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->lokasiobat_id),array('view','id'=>$data->lokasiobat_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('lokasiobat_nama')); ?>:</b>
	<?php echo CHtml::encode($data->lokasiobat_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('lokasiobat_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->lokasiobat_namalain); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('lokasiobat_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->lokasiobat_aktif); ?>
	<br>

</div>