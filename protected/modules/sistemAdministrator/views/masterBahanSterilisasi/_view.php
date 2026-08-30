<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('bahansterilisasi_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->bahansterilisasi_id),array('view','id'=>$data->bahansterilisasi_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('bahansterilisasi_nama')); ?>:</b>
	<?php echo CHtml::encode($data->bahansterilisasi_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('bahansterilisasi_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->bahansterilisasi_namalain); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('bahansterilisasi_jumlah')); ?>:</b>
	<?php echo CHtml::encode($data->bahansterilisasi_jumlah); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('bahansterilisasi_satuan')); ?>:</b>
	<?php echo CHtml::encode($data->bahansterilisasi_satuan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('bahansterilisasi_warna')); ?>:</b>
	<?php echo CHtml::encode($data->bahansterilisasi_warna); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('bahansterilisasi_maksuhu')); ?>:</b>
	<?php echo CHtml::encode($data->bahansterilisasi_maksuhu); ?>
	<br>

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('bahansterilisasi_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->bahansterilisasi_aktif); ?>
	<br>

	*/ ?>

</div>