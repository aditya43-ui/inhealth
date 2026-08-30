<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('detailoperasi_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->detailoperasi_id),array('view','id'=>$data->detailoperasi_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('operasi_id')); ?>:</b>
	<?php echo CHtml::encode($data->operasi_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('detailoperasi_nama')); ?>:</b>
	<?php echo CHtml::encode($data->detailoperasi_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('detailoperasi_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->detailoperasi_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('detailoperasi_aktif')); ?>:</b>
	<?php echo CHtml::encode((($data->detailoperasi_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')))?>
	<br>

</div>