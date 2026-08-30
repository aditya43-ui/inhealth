<div class="view">
	<b><?php echo CHtml::encode($data->getAttributeLabel('pajak_nama')); ?>:</b>
	<?php echo CHtml::encode($data->pajak_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pajak_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->pajak_namalain); ?>
	<br>

	<b>Nama Rekening:</b>
	<?php echo CHtml::encode((isset($data->rekening5)?$data->rekening5->kdrekening5." - ".$data->rekening5->nmrekening5:"")); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('keterangan')); ?>:</b>
	<?php echo CHtml::encode($data->keterangan); ?>
	<br>

	<b>Status:</b>
	<?php echo CHtml::encode(($data->pemeriksaanlabalat_aktif==1)?"Aktif":"Tidak Aktif"); ?>
	<br>

</div>