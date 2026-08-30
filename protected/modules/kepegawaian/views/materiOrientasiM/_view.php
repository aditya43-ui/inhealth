<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('jabatan_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->jabatan_id),array('view','id'=>$data->jabatan_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jabatan_nama')); ?>:</b>
	<?php echo CHtml::encode($data->jabatan_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jabatan_lainnya')); ?>:</b>
	<?php echo CHtml::encode($data->jabatan_lainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jabatan_aktif')); ?>:</b>
	<?php echo CHtml::encode((($data->jabatan_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')))?>
	<br>

</div>