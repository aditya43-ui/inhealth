<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('sumberdana_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->sumberdana_id),array('view','id'=>$data->sumberdana_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('sumberdana_nama')); ?>:</b>
	<?php echo CHtml::encode($data->sumberdana_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('sumberdana_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->sumberdana_namalainnya); ?>
	<br>
        
         <b><?php echo CHtml::encode($data->getAttributeLabel('sumberdana_aktif')); ?>:</b>
	<?php echo CHtml::encode((($data->sumberdana_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')))?>
	<br>
	

</div>