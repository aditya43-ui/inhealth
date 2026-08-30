<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('pemeriksaanlab_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->pemeriksaanlab_id),array('view','id'=>$data->pemeriksaanlab_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenispemeriksaanlab_id')); ?>:</b>
	<?php echo CHtml::encode($data->jenispemeriksaanlab_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('daftartindakan_id')); ?>:</b>
	<?php echo CHtml::encode($data->daftartindakan_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pemeriksaanlab_kode')); ?>:</b>
	<?php echo CHtml::encode($data->pemeriksaanlab_kode); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pemeriksaanlab_urutan')); ?>:</b>
	<?php echo CHtml::encode($data->pemeriksaanlab_urutan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pemeriksaanlab_nama')); ?>:</b>
	<?php echo CHtml::encode($data->pemeriksaanlab_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pemeriksaanlab_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->pemeriksaanlab_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('formathasilperiksa')); ?>:</b>
	<?php echo CHtml::encode($data->formathasilperiksa); ?>
	<br>
	
	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('pemeriksaanlab_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->pemeriksaanlab_aktif); ?>
	<br>

	*/ ?>

</div>