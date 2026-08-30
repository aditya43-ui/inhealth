<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('tugaspengguna_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->tugaspengguna_id),array('view','id'=>$data->tugaspengguna_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('peranpengguna_id')); ?>:</b>
	<?php echo CHtml::encode($data->peranpengguna_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('tugas_nama')); ?>:</b>
	<?php echo CHtml::encode($data->tugas_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('tugas_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->tugas_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('controller_nama')); ?>:</b>
	<?php echo CHtml::encode($data->controller_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('action_nama')); ?>:</b>
	<?php echo CHtml::encode($data->action_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('keterangan_tugas')); ?>:</b>
	<?php echo CHtml::encode($data->keterangan_tugas); ?>
	<br>

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('tugaspengguna_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->tugaspengguna_aktif); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('modul_id')); ?>:</b>
	<?php echo CHtml::encode($data->modul_id); ?>
	<br>

	*/ ?>

</div>