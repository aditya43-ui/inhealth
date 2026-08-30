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
	<?php echo $this->renderPartial($this->path_view.'_obatSupplier',array('supplier_id'=>$data->supplier_id),true)?>
        <br>
        
        <b><?php echo CHtml::encode($data->getAttributeLabel('supplier_aktif')); ?>:</b>
	<?php echo CHtml::encode((($data->supplier_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')))?>
	<br>
</div>