<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('dtd_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->dtd_id),array('view','id'=>$data->dtd_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('dtd_noterperinci')); ?>:</b>
	<?php echo CHtml::encode($data->dtd_noterperinci); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('dtd_nama')); ?>:</b>
	<?php echo CHtml::encode($data->dtd_nama); ?>
	<br>
        <b><?php echo CHtml::encode($data->getAttributeLabel('dtd_menular')); ?>:</b>
	<?php echo CHtml::encode((($data->dtd_menular==1)? Yii::t('mds','Yes') : Yii::t('mds','No')))?>
	<br>
	
        <b><?php echo CHtml::encode($data->getAttributeLabel('dtd_aktif')); ?>:</b>
	<?php echo CHtml::encode((($data->dtd_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')))?>
	<br>

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('dtd_nourut')); ?>:</b>
	<?php echo CHtml::encode($data->dtd_nourut); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('dtd_menular')); ?>:</b>
	<?php echo CHtml::encode($data->dtd_menular); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('dtd_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->dtd_aktif); ?>
	<br>
         *<b><?php echo CHtml::encode($data->getAttributeLabel('dtd_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->dtd_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('dtd_katakunci')); ?>:</b>
	<?php echo CHtml::encode($data->dtd_katakunci); ?>
	<br>

	*/ ?>

</div>