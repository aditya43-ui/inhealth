<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('penggajianpeg_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->penggajianpeg_id),array('view','id'=>$data->penggajianpeg_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pegawai_id')); ?>:</b>
	<?php echo CHtml::encode($data->pegawai_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('tglpenggajian')); ?>:</b>
	<?php echo CHtml::encode($data->tglpenggajian); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('nopenggajian')); ?>:</b>
	<?php echo CHtml::encode($data->nopenggajian); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('keterangan')); ?>:</b>
	<?php echo CHtml::encode($data->keterangan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('mengetahui')); ?>:</b>
	<?php echo CHtml::encode($data->mengetahui); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('menyetujui')); ?>:</b>
	<?php echo CHtml::encode($data->menyetujui); ?>
	<br>

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('totalterima')); ?>:</b>
	<?php echo CHtml::encode($data->totalterima); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('totalpajak')); ?>:</b>
	<?php echo CHtml::encode($data->totalpajak); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('totalpotongan')); ?>:</b>
	<?php echo CHtml::encode($data->totalpotongan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('penerimaanbersih')); ?>:</b>
	<?php echo CHtml::encode($data->penerimaanbersih); ?>
	<br>

	*/ ?>

</div>