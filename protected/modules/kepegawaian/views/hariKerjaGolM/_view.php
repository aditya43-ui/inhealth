<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('harikerjagol_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->harikerjagol_id),array('view','id'=>$data->harikerjagol_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('kelompokpegawai_id')); ?>:</b>
	<?php echo CHtml::encode($data->kelompokpegawai_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('periodeharikerjaawl')); ?>:</b>
	<?php echo CHtml::encode($data->periodeharikerjaawl); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('periodehariakhir')); ?>:</b>
	<?php echo CHtml::encode($data->periodehariakhir); ?>
	<br>
        
        <b><?php echo CHtml::encode($data->getAttributeLabel('periodeharikerjaakhir')); ?>:</b>
	<?php echo CHtml::encode($data->periodeharikerjaakhir); ?>
	<br>
        
    <b><?php echo CHtml::encode($data->getAttributeLabel('harikerjagol_aktif')); ?>:</b>
	<?php echo CHtml::encode((($data->harikerjagol_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')))?>
	<br>
</div>