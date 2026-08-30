<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('kategoritindakan_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->kategoritindakan_id),array('view','id'=>$data->kategoritindakan_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kategoritindakan_nama')); ?>:</b>
	<?php echo CHtml::encode($data->kategoritindakan_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kategoritindakan_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->kategoritindakan_namalainnya); ?>
	<br>
         <b><?php echo CHtml::encode($data->getAttributeLabel('kategoritindakan_aktif')); ?>:</b>
	<?php echo CHtml::encode((($data->kategoritindakan_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')))?>
	<br>


</div>