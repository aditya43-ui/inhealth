<?php
	// $criteria=new CDbCriteria;
 //    $params = array('supplier_id' => true);
 //    $criteria->order = 'rekening1_id';
    $result = AKSupplierRekM::model()->findAllByAttributes('supplier_id=:supplier_id', array(':supplier_id'=>$data->supplier_id));
?>
<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('supplier_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->supplier_id),array('view','id'=>$data->supplier_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('supplier_id')); ?>:</b>
	<?php echo CHtml::encode($data->supplier_nama); ?>
	<br>

	<?php
		foreach($result as $val)
        {
        	$rekening5_id = $val->rekening5_id;
	?>
		<b><?php echo CHtml::encode($data->getAttributeLabel('rekening5_id')); ?>:</b>
		<?php echo CHtml::encode($rekening5_id->rekening5->nmrekening5); ?>
		<br>

	<?php
		}
	?>

</div>