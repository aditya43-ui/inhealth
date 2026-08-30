
<?php
$this->breadcrumbs=array(
	'Transaksi Pengajuan Bahan Makanan',
);
?>
<div class="view">
	<b><?php echo CHtml::encode($data->getAttributeLabel('bahanmenudiet_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->bahanmenudiet_id), array('view', 'id'=>$data->bahanmenudiet_id)); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('menudiet_id')); ?>:</b>
	<?php echo CHtml::encode($data->menudiet_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('bahanmakanan_id')); ?>:</b>
	<?php echo CHtml::encode($data->bahanmakanan_id); ?>
	<br>

	<b><?php echo CHtml::encode($data->getAttributeLabel('jmlbahan')); ?>:</b>
	<?php echo CHtml::encode($data->jmlbahan); ?>
	<br>

</div>