<?php
$this->breadcrumbs = array(
    // 'Informasi Pemesanan Barang'=>Yii::app()->request->getUrlReferrer(),
    'Transaksi Mutasi Barang',
);
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial($this->path_view . '_form', array('model' => $model, 'modDetails' => $modDetails, 'modPesan' => $modPesan, 'linkHalaman' => $linkHalaman)); ?>