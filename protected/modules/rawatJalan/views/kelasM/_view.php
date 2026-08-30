<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelas_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->kelas_id),array('view','id'=>$data->kelas_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelas_nama')); ?>:</b>
	<?php echo CHtml::encode($data->kelas_nama); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelas_kode')); ?>:</b>
	<?php echo CHtml::encode($data->kelas_kode); ?>
	<br />


	<b><?php echo CHtml::encode($data->getAttributeLabel('kelas_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->kelas_aktif); ?>
	<br />


</div>