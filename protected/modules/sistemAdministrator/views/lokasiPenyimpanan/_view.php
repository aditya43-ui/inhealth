<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('lokasipenyimpanan_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->lokasipenyimpanan_id),array('view','id'=>$data->lokasipenyimpanan_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('instalasi_id')); ?>:</b>
	<?php echo CHtml::encode($data->instalasi_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('lokasipenyimpanan_kode')); ?>:</b>
	<?php echo CHtml::encode($data->lokasipenyimpanan_kode); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('lokasipenyimpanan_nama')); ?>:</b>
	<?php echo CHtml::encode($data->lokasipenyimpanan_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('lokasipenyimpanan_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->lokasipenyimpanan_namalain); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('lokasipenyimpanan_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->lokasipenyimpanan_aktif); ?>
	<br>

</div>