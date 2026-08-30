<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('rencanakeperawatan_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->rencanakeperawatan_id),array('view','id'=>$data->rencanakeperawatan_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('diagnosakeperawatan_id')); ?>:</b>
	<?php echo CHtml::encode($data->diagnosakeperawatan_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('rencana_kode')); ?>:</b>
	<?php echo CHtml::encode($data->rencana_kode); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('rencana_intervensi')); ?>:</b>
	<?php echo CHtml::encode($data->rencana_intervensi); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('rencana_rasionalisasi')); ?>:</b>
	<?php echo CHtml::encode($data->rencana_rasionalisasi); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('iskolaborasiintervensi')); ?>:</b>
	<?php echo CHtml::encode($data->iskolaborasiintervensi); ?>
	<br>
        <b><?php echo CHtml::encode('rencanakeperawatan','rencanakeperawatan'); ?>:</b>
	<?php echo $this->renderPartial('_RencanaKeperawatan',array('diagnosakeperawatan_id'=>$data->rencanakeperawatan_id),true)?>

	<?php $rencanakeperawatan_id =(CHtml::encode($data->rencanakeperawatan_aktif == TRUE)) ? Yii::t('mds','Yes') :  Yii::t('mds','No'); echo $rencanakeperawatan_id;?>
	<br>

</div>