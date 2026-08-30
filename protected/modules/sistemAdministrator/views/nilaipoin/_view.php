<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('nilaipoin_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->nilaipoin_id),array('view','id'=>$data->nilaipoin_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('nilaipoin_nama')); ?>:</b>
	<?php echo CHtml::encode($data->nilaipoin_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('nilaipoin_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->nilaipoin_namalain); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('nilaipoin_jumlah')); ?>:</b>
	<?php echo CHtml::encode($data->nilaipoin_jumlah); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('nilaipoin_akitf')); ?>:</b>
	<?php echo CHtml::encode($data->nilaipoin_akitf); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('nilaipoin_tgl')); ?>:</b>
	<?php echo CHtml::encode($data->nilaipoin_tgl); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('nilaipoin_tgl_sd')); ?>:</b>
	<?php echo CHtml::encode($data->nilaipoin_tgl_sd); ?>
	<br>

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('create_time')); ?>:</b>
	<?php echo CHtml::encode($data->create_time); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_time')); ?>:</b>
	<?php echo CHtml::encode($data->update_time); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_loginpemakai_id')); ?>:</b>
	<?php echo CHtml::encode($data->create_loginpemakai_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_loginpemakai_id')); ?>:</b>
	<?php echo CHtml::encode($data->update_loginpemakai_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_ruangan')); ?>:</b>
	<?php echo CHtml::encode($data->create_ruangan); ?>
	<br>

	*/ ?>

</div>