<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenispemeriksaanlab_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->jenispemeriksaanlab_id),array('view','id'=>$data->jenispemeriksaanlab_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenispemeriksaanlab_kode')); ?>:</b>
	<?php echo CHtml::encode($data->jenispemeriksaanlab_kode); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenispemeriksaanlab_urutan')); ?>:</b>
	<?php echo CHtml::encode($data->jenispemeriksaanlab_urutan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenispemeriksaanlab_nama')); ?>:</b>
	<?php echo CHtml::encode($data->jenispemeriksaanlab_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenispemeriksaanlab_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->jenispemeriksaanlab_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenispemeriksaanlab_kelompok')); ?>:</b>
	<?php echo CHtml::encode($data->jenispemeriksaanlab_kelompok); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenispemeriksaanlab_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->jenispemeriksaanlab_aktif); ?>
	<br>

</div>