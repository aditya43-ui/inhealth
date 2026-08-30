<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('gambartubuh_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->gambartubuh_id),array('view','id'=>$data->gambartubuh_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('nama_gambar')); ?>:</b>
	<?php echo CHtml::encode($data->nama_gambar); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('nama_file_gbr')); ?>:</b>
	<?php echo CHtml::encode($data->nama_file_gbr); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('path_gambar')); ?>:</b>
	<?php echo CHtml::encode($data->path_gambar); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('gambar_resolusi_x')); ?>:</b>
	<?php echo CHtml::encode($data->gambar_resolusi_x); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('gambar_resolusi_y')); ?>:</b>
	<?php echo CHtml::encode($data->gambar_resolusi_y); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('gambar_create')); ?>:</b>
	<?php echo CHtml::encode($data->gambar_create); ?>
	<br>

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('gambar_update')); ?>:</b>
	<?php echo CHtml::encode($data->gambar_update); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('gambartubuh_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->gambartubuh_aktif); ?>
	<br>

	*/ ?>

</div>