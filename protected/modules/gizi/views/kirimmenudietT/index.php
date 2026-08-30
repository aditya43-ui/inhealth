<?php $linkHalaman = CustomFunction::getUrlByMenuID(392); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Pemesanan Menu Diet Pasien' => Yii::app()->request->getUrlReferrer(),
    'Transaksi Pengiriman Menu Diet Pasien',
);
?>
<?php
$this->widget('bootstrap.widgets.BootAlert');
?>
<?php echo $this->renderPartial('_form', array(
    'model' => $model,
    'modPesan' => $modPesan,
    'modDetailPesan' => $modDetailPesan,
    'modPendaftaran' => $modPendaftaran,
    'modPasienPenunjang' => $modPasienPenunjang,
    'modDetailKirim' => $modDetailKirim,
    'linkHalaman' => $linkHalaman
)); ?>
