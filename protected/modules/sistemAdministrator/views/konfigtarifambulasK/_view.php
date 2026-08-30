<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('konfigtarifambulans_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->konfigtarifambulans_id),array('view','id'=>$data->konfigtarifambulans_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('konfigtarifambulans_id')); ?>:</b>
	<?php echo CHtml::encode($data->konfigtarifambulans_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('komponenunit_id')); ?>:</b>
	<?php echo CHtml::encode($data->komponenunit_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jasaparamedis')); ?>:</b>
	<?php echo CHtml::encode($data->jasaparamedis); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('akomodasimedis')); ?>:</b>
	<?php echo CHtml::encode($data->akomodasimedis); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('uanghariandokter')); ?>:</b>
	<?php echo CHtml::encode($data->uanghariandokter); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('uangmakandokter')); ?>:</b>
	<?php echo CHtml::encode($data->uangmakandokter); ?>
	<br>

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('konfigurasitarifambulans_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->konfigurasitarifambulans_aktif); ?>
	<br>

	*/ ?>

</div>