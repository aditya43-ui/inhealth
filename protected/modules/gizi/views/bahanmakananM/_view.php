<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('bahanmakanan_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->bahanmakanan_id), array('view', 'id'=>$data->bahanmakanan_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('golbahanmakanan_id')); ?>:</b>
	<?php echo CHtml::encode($data->golbahanmakanan_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('sumberdanabhn')); ?>:</b>
	<?php echo CHtml::encode($data->sumberdanabhn); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenisbahanmakanan')); ?>:</b>
	<?php echo CHtml::encode($data->jenisbahanmakanan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelbahanmakanan')); ?>:</b>
	<?php echo CHtml::encode($data->kelbahanmakanan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('namabahanmakanan')); ?>:</b>
	<?php echo CHtml::encode($data->namabahanmakanan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jmlpersediaan')); ?>:</b>
	<?php echo CHtml::encode($data->jmlpersediaan); ?>
	<br>

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('satuanbahan')); ?>:</b>
	<?php echo CHtml::encode($data->satuanbahan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('harganettobahan')); ?>:</b>
	<?php echo CHtml::encode($data->harganettobahan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('hargajualbahan')); ?>:</b>
	<?php echo CHtml::encode($data->hargajualbahan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('discount')); ?>:</b>
	<?php echo CHtml::encode($data->discount); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('tglkadaluarsabahan')); ?>:</b>
	<?php echo CHtml::encode($data->tglkadaluarsabahan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jmlminimal')); ?>:</b>
	<?php echo CHtml::encode($data->jmlminimal); ?>
	<br>

	*/ ?>

</div>