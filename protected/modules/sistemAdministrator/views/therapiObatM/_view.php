<div class="view">
	<b><?php echo CHtml::encode($data->getAttributeLabel('therapiobat_nama')); ?>:</b>
	<?php echo CHtml::encode($data->therapiobat_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('therapiobat_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->therapiobat_namalain); ?>
	<br>
        
         <b><?php echo CHtml::encode($data->getAttributeLabel('therapiobat_aktif')); ?>:</b>
	<?php echo CHtml::encode((($data->therapiobat_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')))?>
	<br>


</div>