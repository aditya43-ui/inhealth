<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('supplier_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->supplier_id),array('view','id'=>$data->supplier_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('supplier_kode')); ?>:</b>
	<?php echo CHtml::encode($data->supplier_kode); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('supplier_nama')); ?>:</b>
	<?php echo CHtml::encode($data->supplier_nama); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('supplier_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->supplier_namalain); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('supplier_alamat')); ?>:</b>
	<?php echo CHtml::encode($data->supplier_alamat); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('supplier_propinsi')); ?>:</b>
	<?php echo CHtml::encode($data->supplier_propinsi); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('supplier_kabupaten')); ?>:</b>
	<?php echo CHtml::encode($data->supplier_kabupaten); ?>
	<br>
        
	<b><?php echo CHtml::encode($data->getAttributeLabel('obatalkes_nama')); ?>:</b>
	<?php echo $this->renderPartial('_obatSupplier',array('supplier_id'=>$data->supplier_id),true)?>
        <br>
        
        <b><?php echo CHtml::encode($data->getAttributeLabel('supplier_aktif')); ?>:</b>
	<?php echo CHtml::encode((($data->supplier_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')))?>
	<br>
	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('supplier_telp')); ?>:</b>
	<?php echo CHtml::encode($data->supplier_telp); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('supplier_fax')); ?>:</b>
	<?php echo CHtml::encode($data->supplier_fax); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('supplier_kodepos')); ?>:</b>
	<?php echo CHtml::encode($data->supplier_kodepos); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('supplier_npwp')); ?>:</b>
	<?php echo CHtml::encode($data->supplier_npwp); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('supplier_website')); ?>:</b>
	<?php echo CHtml::encode($data->supplier_website); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('supplier_email')); ?>:</b>
	<?php echo CHtml::encode($data->supplier_email); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('supplier_cp')); ?>:</b>
	<?php echo CHtml::encode($data->supplier_cp); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('supplier_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->supplier_aktif); ?>
	<br>

	*/ ?>

</div>