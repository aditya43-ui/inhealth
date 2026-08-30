<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('kursrp_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->kursrp_id),array('view','id'=>$data->kursrp_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('matauang_id')); ?>:</b>
	<?php echo CHtml::encode($data->matauang->matauang); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('tglkursrp')); ?>:</b>
	<?php echo CHtml::encode($data->tglkursrp); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('nilai')); ?>:</b>
	<?php echo CHtml::encode($data->nilai); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('rupiah')); ?>:</b>
	<?php echo CHtml::encode($data->rupiah); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kursrp_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->kursrp_aktif); ?>
	<br>
</div>