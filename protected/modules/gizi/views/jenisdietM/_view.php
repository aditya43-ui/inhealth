<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisdiet_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->jenisdiet_id), array('view', 'id'=>$data->jenisdiet_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisdiet_nama')); ?>:</b>
	<?php echo CHtml::encode($data->jenisdiet_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisdiet_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->jenisdiet_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisdiet_keterangan')); ?>:</b>
	<?php echo CHtml::encode($data->jenisdiet_keterangan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisdiet_catatan')); ?>:</b>
	<?php echo nl2br(CHtml::encode($data->jenisdiet_catatan)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisdiet_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->jenisdiet_aktif); ?>
	<br>

</div>