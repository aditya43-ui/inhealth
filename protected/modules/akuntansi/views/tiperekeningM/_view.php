<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('tiperekening_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->tiperekening_id),array('view','id'=>$data->tiperekening_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('tiperekening')); ?>:</b>
	<?php echo CHtml::encode($data->tiperekening); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('keterangan')); ?>:</b>
	<?php echo CHtml::encode($data->keterangan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('tiperekening_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->tiperekening_aktif); ?>
	<br>

</div>