<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('tarifambulans_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->tarifambulans_id), array('view', 'id'=>$data->tarifambulans_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('daftartindakan_id')); ?>:</b>
	<?php echo CHtml::encode($data->daftartindakan_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('tarifambulans_kode')); ?>:</b>
	<?php echo CHtml::encode($data->tarifambulans_kode); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kepropinsi_nama')); ?>:</b>
	<?php echo CHtml::encode($data->kepropinsi_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kekabupaten_nama')); ?>:</b>
	<?php echo CHtml::encode($data->kekabupaten_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kekecamatan_nama')); ?>:</b>
	<?php echo CHtml::encode($data->kekecamatan_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kekelurahan_nama')); ?>:</b>
	<?php echo CHtml::encode($data->kekelurahan_nama); ?>
	<br>

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('jmlkilometer')); ?>:</b>
	<?php echo CHtml::encode($data->jmlkilometer); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('tarifperkm')); ?>:</b>
	<?php echo CHtml::encode($data->tarifperkm); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('tarifambulans')); ?>:</b>
	<?php echo CHtml::encode($data->tarifambulans); ?>
	<br>

	*/ ?>

</div>