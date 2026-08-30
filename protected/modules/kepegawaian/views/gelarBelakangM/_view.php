<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('gelarbelakang_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->gelarbelakang_id),array('view','id'=>$data->gelarbelakang_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('gelarbelakang_nama')); ?>:</b>
	<?php echo CHtml::encode($data->gelarbelakang_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('gelarbelakang_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->gelarbelakang_namalainnya); ?>
	<br>
        
        <b><?php echo CHtml::encode($data->getAttributeLabel('gelarbelakang_aktif')); ?>:</b>
	<?php echo CHtml::encode((($data->gelarbelakang_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')))?>
	<br>
</div>