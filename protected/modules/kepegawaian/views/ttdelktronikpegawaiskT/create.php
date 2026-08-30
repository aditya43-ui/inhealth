<?php
$this->breadcrumbs=array(
	'Surat Keputusan Tanda Tangan Elektronik'=>array('create'),
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Transaksi Dokumentasi Surat Keputusan Tanda Tangan Elektronik</div>
    </div>
    <div class="panel-body">
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        
        
	<?php echo $this->renderPartial('_pegawai', array(
            'pegawai'=>$pegawai, 
        )); ?>
	<?php echo $this->renderPartial('_riwayat', array(
            'model'=>$model, 
            'riwayat' => $riwayat,
        )); ?>
        
	<?php echo $this->renderPartial('_form', array(
            'model'=>$model, 
            'riwayat' => $riwayat,
            'pegawai'=>$pegawai, 
        )); ?>
    </div>
</div>
