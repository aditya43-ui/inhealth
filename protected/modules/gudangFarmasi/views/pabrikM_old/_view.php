<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('pabrik_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->pabrik_id),array('view','id'=>$data->pabrik_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pabrik_kode')); ?>:</b>
	<?php echo CHtml::encode($data->pabrik_kode); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pabrik_nama')); ?>:</b>
	<?php echo CHtml::encode($data->pabrik_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pabrik_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->pabrik_namalain); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pabrik_alamat')); ?>:</b>
	<?php echo CHtml::encode($data->pabrik_alamat); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pabrik_propinsi')); ?>:</b>
	<?php echo CHtml::encode($data->pabrik_propinsi); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pabrik_kabupaten')); ?>:</b>
	<?php echo CHtml::encode($data->pabrik_kabupaten); ?>
	<br>

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('pabrik_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->pabrik_aktif); ?>
	<br>

	*/ ?>

</div>