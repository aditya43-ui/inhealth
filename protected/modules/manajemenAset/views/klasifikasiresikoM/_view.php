<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('klasfikasiresiko_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->klasfikasiresiko_id),array('view','id'=>$data->klasfikasiresiko_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('klasfikasiresiko_id')); ?>:</b>
	<?php echo CHtml::encode($data->klasfikasiresiko_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelompokresiko')); ?>:</b>
	<?php echo CHtml::encode($data->kelompokresiko); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kategori_resiko')); ?>:</b>
	<?php echo CHtml::encode($data->kategori_resiko); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nilai_resiko')); ?>:</b>
	<?php echo CHtml::encode($data->nilai_resiko); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenis_resiko')); ?>:</b>
	<?php echo CHtml::encode($data->jenis_resiko); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('defenisi_resiko')); ?>:</b>
	<?php echo CHtml::encode($data->defenisi_resiko); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('resiko_ket')); ?>:</b>
	<?php echo CHtml::encode($data->resiko_ket); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('klasifikasiresiko_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->klasifikasiresiko_aktif); ?>
	<br />

	*/ ?>

</div>