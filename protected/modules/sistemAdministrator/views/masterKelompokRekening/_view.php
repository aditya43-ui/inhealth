<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelrekening_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->kelrekening_id),array('view','id'=>$data->kelrekening_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('koderekeningkel')); ?>:</b>
	<?php echo CHtml::encode($data->koderekeningkel); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('namakelrekening')); ?>:</b>
	<?php echo CHtml::encode($data->namakelrekening); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelrekening_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->kelrekening_aktif); ?>
	<br>

</div>