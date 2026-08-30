<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenispenilaian_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->jenispenilaian_id),array('view','id'=>$data->jenispenilaian_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jabatan_id')); ?>:</b>
	<?php echo CHtml::encode($data->jabatan_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenispenilaian_nama')); ?>:</b>
	<?php echo CHtml::encode($data->jenispenilaian_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenispenilaian_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->jenispenilaian_namalain); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenispenilaian_sifat')); ?>:</b>
	<?php echo CHtml::encode($data->jenispenilaian_sifat); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenispenilaian_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->jenispenilaian_aktif); ?>
	<br>

</div>