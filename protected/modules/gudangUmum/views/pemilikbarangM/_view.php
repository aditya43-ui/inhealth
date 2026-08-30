<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('pemilikbarang_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->pemilikbarang_id),array('view','id'=>$data->pemilikbarang_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pemilikbarang_kode')); ?>:</b>
	<?php echo CHtml::encode($data->pemilikbarang_kode); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pemilikbarang_nama')); ?>:</b>
	<?php echo CHtml::encode($data->pemilikbarang_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pemilikbarang_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->pemilikbarang_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pemilikbarang_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->pemilikbarang_aktif); ?>
	<br>

</div>