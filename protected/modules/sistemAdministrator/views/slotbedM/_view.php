<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('slotbed_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->slotbed_id),array('view','id'=>$data->slotbed_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('instalasi_id')); ?>:</b>
	<?php echo CHtml::encode($data->instalasi->instalasi_nama); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pegawai_id')); ?>:</b>
	<?php echo CHtml::encode($data->pegawai->nama_pegawai); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jadwal_hari')); ?>:</b>
	<?php echo CHtml::encode($data->jadwal_hari); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jadwal_buka')); ?>:</b>
	<?php echo CHtml::encode($data->jadwal_buka); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jadwal_mulai')); ?>:</b>
	<?php echo CHtml::encode($data->jadwal_mulai); ?>
	<br />

</div>