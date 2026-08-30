<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('unitkerja_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->unitkerja_id),array('view','id'=>$data->unitkerja_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kodeunitkerja')); ?>:</b>
	<?php echo CHtml::encode($data->kodeunitkerja); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('namaunitkerja')); ?>:</b>
	<?php echo CHtml::encode($data->namaunitkerja); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('namalain')); ?>:</b>
	<?php echo CHtml::encode($data->namalain); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('unitkerja_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->unitkerja_aktif); ?>
	<br>

</div>