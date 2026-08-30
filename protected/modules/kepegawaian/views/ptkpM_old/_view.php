<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('ptkp_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->ptkp_id),array('view','id'=>$data->ptkp_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('tglberlaku')); ?>:</b>
	<?php echo CHtml::encode($data->tglberlaku); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('statusperkawinan')); ?>:</b>
	<?php echo CHtml::encode($data->statusperkawinan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jmltanggunan')); ?>:</b>
	<?php echo CHtml::encode($data->jmltanggungan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('wajibpajak_thn')); ?>:</b>
	<?php echo CHtml::encode($data->wajibpajak_thn); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('wajibpajak_bln')); ?>:</b>
	<?php echo CHtml::encode($data->wajibpajak_bln); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('berlaku')); ?>:</b>
	<?php echo CHtml::encode($data->berlaku); ?>
	<br>

</div>