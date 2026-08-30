<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('jadwaldokter_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->jadwaldokter_id),array('view','id'=>$data->jadwaldokter_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('instalasi_id')); ?>:</b>
	<?php echo CHtml::encode($data->instalasi->instalasi_nama); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ruangan_id')); ?>:</b>
	<?php echo CHtml::encode($data->ruangan->ruangan_nama); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pegawai_id')); ?>:</b>
	<?php echo CHtml::encode($data->pegawai->nama_pegawai); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jadwaldokter_hari')); ?>:</b>
	<?php echo CHtml::encode($data->jadwaldokter_hari); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jadwaldokter_buka')); ?>:</b>
	<?php echo CHtml::encode($data->jadwaldokter_buka); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jadwaldokter_mulai')); ?>:</b>
	<?php echo CHtml::encode($data->jadwaldokter_mulai); ?>
	<br />

</div>