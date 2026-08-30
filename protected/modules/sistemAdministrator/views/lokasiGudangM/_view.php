<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('lokasigudang_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->lokasigudang_id),array('view','id'=>$data->lokasigudang_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('lokasigudang_nama')); ?>:</b>
	<?php echo CHtml::encode($data->lokasigudang_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('lokasigudang_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->lokasigudang_namalain); ?>
	<br>
        
         <b><?php echo CHtml::encode($data->getAttributeLabel('lokasigudang_aktif')); ?>:</b>
	<?php echo CHtml::encode((($data->lokasigudang_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')))?>
	<br>
        


</div>