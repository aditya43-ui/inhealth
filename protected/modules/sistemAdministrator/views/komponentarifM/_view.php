<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('komponentarif_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->komponentarif_id),array('view','id'=>$data->komponentarif_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('komponentarif_nama')); ?>:</b>
	<?php echo CHtml::encode($data->komponentarif_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('komponentarif_namalainnya')); ?>:</b>
	<?php echo CHtml::encode($data->komponentarif_namalainnya); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('komponentarif_urutan')); ?>:</b>
	<?php echo CHtml::encode($data->komponentarif_urutan); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('komponentarif_aktif')); ?>:</b>
<<<<<<< HEAD
	<?php echo CHtml::encode($data->komponentarif_aktif); ?>
	<br>
                <b><?php echo CHtml::encode('Instalasi','Instalasi'); ?>:</b>
	<?php echo $this->renderPartial($this->path_view.'_komponenTarifInstalasi',array('komponentarif_id'=>$data->komponentarif_id),true)?>
=======
	<?php $komponentarif_aktif =(CHtml::encode($data->komponentarif_aktif == TRUE)) ? Yii::t('mds','Yes') :  Yii::t('mds','No'); echo $komponentarif_aktif;?>
>>>>>>> fafc57a49c209e4d3de42710cb68d0ea8b65c241
	<br>

</div>