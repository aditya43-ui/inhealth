<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('loket_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->loket_id),array('view','id'=>$data->loket_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('loket_nama')); ?>:</b>
	<?php echo CHtml::encode($data->loket_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('loket_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->loket_namalain); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('loket_fungsi')); ?>:</b>
	<?php echo CHtml::encode($data->loket_fungsi); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('loket_singkatan')); ?>:</b>
	<?php echo CHtml::encode($data->loket_singkatan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('loket_nourut')); ?>:</b>
	<?php echo CHtml::encode($data->loket_nourut); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('loket_formatnomor')); ?>:</b>
	<?php echo CHtml::encode($data->loket_formatnomor); ?>
	<br>

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('loket_maksantrian')); ?>:</b>
	<?php echo CHtml::encode($data->loket_maksantrian); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('loket_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->loket_aktif); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('carabayar_id')); ?>:</b>
	<?php echo CHtml::encode($data->carabayar_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('filesuara')); ?>:</b>
	<?php echo CHtml::encode($data->filesuara); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('ispendaftaran')); ?>:</b>
	<?php echo CHtml::encode($data->ispendaftaran); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('iskasir')); ?>:</b>
	<?php echo CHtml::encode($data->iskasir); ?>
	<br>

	*/ ?>

</div>