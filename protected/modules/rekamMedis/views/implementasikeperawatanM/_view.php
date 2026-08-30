<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('implementasikeperawatan_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->implementasikeperawatan_id),array('view','id'=>$data->implementasikeperawatan_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('diagnosakeperawatan_id')); ?>:</b>
	<?php echo CHtml::encode($data->diagnosakeperawatan_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('rencanakeperawatan_id')); ?>:</b>
	<?php echo CHtml::encode($data->rencanakeperawatan_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('implementasikeperawatan_kode')); ?>:</b>
	<?php echo CHtml::encode($data->implementasikeperawatan_kode); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('implementasi_nama')); ?>:</b>
	<?php echo CHtml::encode($data->implementasi_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('iskolaborasiimplementasi')); ?>:</b>
	<?php echo CHtml::encode($data->iskolaborasiimplementasi); ?>
	<br>
        <b><?php echo CHtml::encode('implementasikeperawatan','implementasikeperawatan'); ?>:</b>
	<?php echo $this->renderPartial('_implementasi',array('diagnosakeperawatan_id'=>$data->diagnosakeperawatan_id),true)?>
=======
	<?php // $lookup_id =(CHtml::encode($data->lookup_aktif == TRUE)) ? Yii::t('mds','Yes') :  Yii::t('mds','No'); echo $lookup_aktif;?>
>>>>>>> fafc57a49c209e4d3de42710cb68d0ea8b65c241
	<br>

</div>