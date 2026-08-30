<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('satuankecil_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->satuankecil_id),array('view','id'=>$data->satuankecil_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('satuankecil_nama')); ?>:</b>
	<?php echo CHtml::encode($data->satuankecil_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('satuankecil_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->satuankecil_namalain); ?>
	<br>

        <b><?php echo CHtml::encode($data->getAttributeLabel('satuankecil_aktif')); ?>:</b>
	<?php echo CHtml::encode((($data->satuankecil_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')))?>
	<br>
	

</div>