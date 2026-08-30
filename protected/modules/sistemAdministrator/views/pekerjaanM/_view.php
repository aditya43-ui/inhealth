<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('pekerjaan_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->pekerjaan_id),array('view','id'=>$data->pekerjaan_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pekerjaan_nama')); ?>:</b>
	<?php echo CHtml::encode($data->pekerjaan_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pekerjaan_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->pekerjaan_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('pekerjaan_aktif')); ?>:</b>
	<?php echo CHtml::encode((($data->pekerjaan_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')))?>
	<br>

</div>