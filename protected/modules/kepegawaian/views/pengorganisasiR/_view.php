<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('pengorganisasi_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->pengorganisasi_id),array('view','id'=>$data->pengorganisasi_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pegawai_id')); ?>:</b>
	<?php echo CHtml::encode($data->pegawai_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pengorganisasi_nama')); ?>:</b>
	<?php echo CHtml::encode($data->pengorganisasi_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pengorganisasi_kedudukan')); ?>:</b>
	<?php echo CHtml::encode($data->pengorganisasi_kedudukan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pengorganisasi_lamanya')); ?>:</b>
	<?php echo CHtml::encode($data->pengorganisasi_lamanya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pengorganisasi_tahun')); ?>:</b>
	<?php echo CHtml::encode($data->pengorganisasi_tahun); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pengorganisasi_tempat')); ?>:</b>
	<?php echo CHtml::encode($data->pengorganisasi_tempat); ?>
	<br>

</div>