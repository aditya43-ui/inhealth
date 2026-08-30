<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('zatgizi_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->zatgizi_id), array('view', 'id'=>$data->zatgizi_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('zatgizi_nama')); ?>:</b>
	<?php echo CHtml::encode($data->zatgizi_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('zatgizi_satuan')); ?>:</b>
	<?php echo CHtml::encode($data->zatgizi_satuan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('zatgizi_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->zatgizi_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('zatgizi_aktif')); ?>:</b>
	<?php $zatgizi_aktif =(CHtml::encode($data->zatgizi_aktif == TRUE)) ? Yii::t('mds','Yes') :  Yii::t('mds','No'); echo $zatgizi_aktif;?>
	<br>

</div>