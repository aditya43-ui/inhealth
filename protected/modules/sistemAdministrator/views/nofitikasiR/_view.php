<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('nofitikasi_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->nofitikasi_id),array('view','id'=>$data->nofitikasi_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('instalasi_id')); ?>:</b>
	<?php echo CHtml::encode($data->instalasi_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('modul_id')); ?>:</b>
	<?php echo CHtml::encode($data->modul_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('tglnotifikasi')); ?>:</b>
	<?php echo CHtml::encode($data->tglnotifikasi); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('judulnotifikasi')); ?>:</b>
	<?php echo CHtml::encode($data->judulnotifikasi); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('isinotifikasi')); ?>:</b>
	<?php echo CHtml::encode($data->isinotifikasi); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('isread')); ?>:</b>
	<?php echo CHtml::encode($data->isread); ?>
	<br>

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('create_time')); ?>:</b>
	<?php echo CHtml::encode($data->create_time); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_time')); ?>:</b>
	<?php echo CHtml::encode($data->update_time); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_loginpemakai_id')); ?>:</b>
	<?php echo CHtml::encode($data->create_loginpemakai_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_loginpemakai_id')); ?>:</b>
	<?php echo CHtml::encode($data->update_loginpemakai_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_ruangan')); ?>:</b>
	<?php echo CHtml::encode($data->create_ruangan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('lamahrnotif')); ?>:</b>
	<?php echo CHtml::encode($data->lamahrnotif); ?>
	<br>

	*/ ?>

</div>