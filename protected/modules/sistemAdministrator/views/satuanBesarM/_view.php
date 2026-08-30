<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('satuanbesar_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->satuanbesar_id),array('view','id'=>$data->satuanbesar_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('satuanbesar_nama')); ?>:</b>
	<?php echo CHtml::encode($data->satuanbesar_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('satuanbesar_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->satuanbesar_namalain); ?>
	<br>
        
        <b><?php echo CHtml::encode($data->getAttributeLabel('satuanbesar_aktif')); ?>:</b>
	<?php echo CHtml::encode((($data->satuanbesar_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')))?>
	<br>


</div>