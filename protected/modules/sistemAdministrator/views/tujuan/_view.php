<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('periodeposting_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->periodeposting_id),array('view','id'=>$data->periodeposting_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('konfiganggaran_id')); ?>:</b>
	<?php echo CHtml::encode($data->konfiganggaran_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('periodeposting_nama')); ?>:</b>
	<?php echo CHtml::encode($data->periodeposting_nama); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tglperiodeposting_awal')); ?>:</b>
	<?php echo CHtml::encode($data->tglperiodeposting_awal); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tglperiodeposting_akhir')); ?>:</b>
	<?php echo CHtml::encode($data->tglperiodeposting_akhir); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('deskripsiperiodeposting')); ?>:</b>
	<?php echo CHtml::encode($data->deskripsiperiodeposting); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_time')); ?>:</b>
	<?php echo CHtml::encode($data->create_time); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('update_time')); ?>:</b>
	<?php echo CHtml::encode($data->update_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_loginpemakai_id')); ?>:</b>
	<?php echo CHtml::encode($data->create_loginpemakai_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_loginpemakai_id')); ?>:</b>
	<?php echo CHtml::encode($data->update_loginpemakai_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_ruangan')); ?>:</b>
	<?php echo CHtml::encode($data->create_ruangan); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('periodeposting_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->periodeposting_aktif); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rekperiode_id')); ?>:</b>
	<?php echo CHtml::encode($data->rekperiode_id); ?>
	<br />

	*/ ?>

</div>