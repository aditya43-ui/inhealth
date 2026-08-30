<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('rakpenyimpanan_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->rakpenyimpanan_id),array('view','id'=>$data->rakpenyimpanan_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('lokasipenyimpanan_id')); ?>:</b>
	<?php echo CHtml::encode($data->lokasipenyimpanan_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('rakpenyimpanan_label')); ?>:</b>
	<?php echo CHtml::encode($data->rakpenyimpanan_label); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('rakpenyimpanan_kode')); ?>:</b>
	<?php echo CHtml::encode($data->rakpenyimpanan_kode); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('rakpenyimpanan_nama')); ?>:</b>
	<?php echo CHtml::encode($data->rakpenyimpanan_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('rakpenyimpanan_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->rakpenyimpanan_namalain); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('rakpenyimpanan_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->rakpenyimpanan_aktif); ?>
	<br>

</div>