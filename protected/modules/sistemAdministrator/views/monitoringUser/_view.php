<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('loginpemakai_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->loginpemakai_id),array('view','id'=>$data->loginpemakai_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pegawai_id')); ?>:</b>
	<?php echo CHtml::encode($data->pegawai_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pasien_id')); ?>:</b>
	<?php echo CHtml::encode($data->pasien_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('nama_pemakai')); ?>:</b>
	<?php echo CHtml::encode($data->nama_pemakai); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('katakunci_pemakai')); ?>:</b>
	<?php echo CHtml::encode($data->katakunci_pemakai); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('lastlogin')); ?>:</b>
	<?php echo CHtml::encode($data->lastlogin); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('tglpembuatanlogin')); ?>:</b>
	<?php echo CHtml::encode($data->tglpembuatanlogin); ?>
	<br>

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('tglupdatelogin')); ?>:</b>
	<?php echo CHtml::encode($data->tglupdatelogin); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('statuslogin')); ?>:</b>
	<?php echo CHtml::encode($data->statuslogin); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('photouser')); ?>:</b>
	<?php echo CHtml::encode($data->photouser); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('loginpemakai_create')); ?>:</b>
	<?php echo CHtml::encode($data->loginpemakai_create); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('loginpemakai_update')); ?>:</b>
	<?php echo CHtml::encode($data->loginpemakai_update); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('loginpemakai_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->loginpemakai_aktif); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('ruanganaktifitas')); ?>:</b>
	<?php echo CHtml::encode($data->ruanganaktifitas); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('crudaktifitas')); ?>:</b>
	<?php echo CHtml::encode($data->crudaktifitas); ?>
	<br>

	*/ ?>

</div>