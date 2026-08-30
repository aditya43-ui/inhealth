<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenistarif_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->jenistarif_id),array('view','id'=>$data->jenistarif_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenistarif_nama')); ?>:</b>
	<?php echo CHtml::encode($data->jenistarif_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenistarif_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->jenistarif_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenistarif_aktif')); ?>:</b>
	<?php $jenistarif_aktif =(CHtml::encode($data->jenistarif_aktif == TRUE)) ? Yii::t('mds','Yes') :  Yii::t('mds','No'); echo $jenistarif_aktif;?>
	<br>

</div>