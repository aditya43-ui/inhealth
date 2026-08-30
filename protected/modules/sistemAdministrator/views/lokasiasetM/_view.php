<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('lokasi_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->lokasi_id),array('view','id'=>$data->lokasi_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('lokasiaset_kode')); ?>:</b>
	<?php echo CHtml::encode($data->lokasiaset_kode); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('lokasiaset_namainstalasi')); ?>:</b>
	<?php echo CHtml::encode($data->lokasiaset_namainstalasi); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('lokasiaset_namabagian')); ?>:</b>
	<?php echo CHtml::encode($data->lokasiaset_namabagian); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('lokasiaset_namalokasi')); ?>:</b>
	<?php echo CHtml::encode($data->lokasiaset_namalokasi); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('lokasiaset_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->lokasiaset_aktif); ?>
	<br>

</div>