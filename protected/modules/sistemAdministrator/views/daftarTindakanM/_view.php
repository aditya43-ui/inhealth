<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('daftartindakan_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->daftartindakan_id),array('view','id'=>$data->daftartindakan_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('komponenunit_id')); ?>:</b>
	<?php echo CHtml::encode($data->komponenunit->komponenunit_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kategoritindakan_id')); ?>:</b>
	<?php echo CHtml::encode($data->kategoritindakan->kategoritindakan_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelompoktindakan_id')); ?>:</b>
	<?php echo CHtml::encode($data->kelompoktindakan->kelompoktindakan_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('daftartindakan_kode')); ?>:</b>
	<?php echo CHtml::encode($data->daftartindakan_kode); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('daftartindakan_nama')); ?>:</b>
	<?php echo CHtml::encode($data->daftartindakan_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('tindakanmedis_nama')); ?>:</b>
	<?php echo CHtml::encode($data->tindakanmedis_nama); ?>
	<br>
                <b><?php echo CHtml::encode('Ruangan','Ruangan'); ?>:</b>
	<?php echo $this->renderPartial('_ruangan',array('daftartindakan_id'=>$data->daftartindakan_id),true)?>

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('daftartindakan_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->daftartindakan_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('daftartindakan_katakunci')); ?>:</b>
	<?php echo CHtml::encode($data->daftartindakan_katakunci); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('daftartindakan_karcis')); ?>:</b>
	<?php echo CHtml::encode($data->daftartindakan_karcis); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('daftartindakan_visite')); ?>:</b>
	<?php echo CHtml::encode($data->daftartindakan_visite); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('daftartindakan_konsul')); ?>:</b>
	<?php echo CHtml::encode($data->daftartindakan_konsul); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('daftartindakan_akomodasi')); ?>:</b>
	<?php echo CHtml::encode($data->daftartindakan_akomodasi); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('daftartindakan_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->daftartindakan_aktif); ?>
	<br>

	*/ ?>

</div>