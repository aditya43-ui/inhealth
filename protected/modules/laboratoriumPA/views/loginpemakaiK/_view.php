<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('loginpemakai_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->loginpemakai_id),array('view','id'=>$data->loginpemakai_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nama_pemakai')); ?>:</b>
	<?php echo CHtml::encode($data->nama_pemakai); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('katakunci_pemakai')); ?>:</b>
	<?php echo CHtml::encode($data->katakunci_pemakai); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lastlogin')); ?>:</b>
	<?php echo CHtml::encode($data->lastlogin); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tglpembuatanlogin')); ?>:</b>
	<?php echo CHtml::encode($data->tglpembuatanlogin); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tglupdatelogin')); ?>:</b>
	<?php echo CHtml::encode($data->tglupdatelogin); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('statuslogin')); ?>:</b>
	<?php $statuslogin =(CHtml::encode($data->statuslogin == TRUE)) ? Yii::t('mds','Yes') :  Yii::t('mds','No'); echo $statuslogin;  ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('loginpemakai_aktif')); ?>:</b>
	<?php $loginpemakai_aktif =(CHtml::encode($data->loginpemakai_aktif == TRUE)) ? Yii::t('mds','Yes') :  Yii::t('mds','No'); echo $loginpemakai_aktif;?>
	<br />

	

</div>