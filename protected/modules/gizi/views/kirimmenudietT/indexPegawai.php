<?php
$this->breadcrumbs = array(
    'Informasi Pemesanan Menu Diet Pegawai' => Yii::app()->request->getUrlReferrer(),
    'Transaksi Pengiriman Menu Pegawai',
);

$this->widget('bootstrap.widgets.BootAlert');
?>

<?php
$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial('_formPegawai', array('model' => $model, 'modPesan' => $modPesan, 'modDetailPesan' => $modDetailPesan)); ?>
