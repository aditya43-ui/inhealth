<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('pembelianbarang_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->pembelianbarang_id),array('view','id'=>$data->pembelianbarang_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('terimapersediaan_id')); ?>:</b>
	<?php echo CHtml::encode($data->terimapersediaan_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sumberdana_id')); ?>:</b>
	<?php echo CHtml::encode($data->sumberdana_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('supplier_id')); ?>:</b>
	<?php echo CHtml::encode($data->supplier_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tglpembelian')); ?>:</b>
	<?php echo CHtml::encode($data->tglpembelian); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nopembelian')); ?>:</b>
	<?php echo CHtml::encode($data->nopembelian); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tgldikirim')); ?>:</b>
	<?php echo CHtml::encode($data->tgldikirim); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('peg_pemesanan_id')); ?>:</b>
	<?php echo CHtml::encode($data->peg_pemesanan_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('peg_mengetahui_id')); ?>:</b>
	<?php echo CHtml::encode($data->peg_mengetahui_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('peg_menyetujui_id')); ?>:</b>
	<?php echo CHtml::encode($data->peg_menyetujui_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_time')); ?>:</b>
	<?php echo CHtml::encode($data->create_time); ?>
	<br />

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

	*/ ?>

</div>