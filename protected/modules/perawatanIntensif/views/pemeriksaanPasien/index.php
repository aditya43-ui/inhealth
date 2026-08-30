<?php 
$this->breadcrumbs = array(
    'Informasi Rawat Intensif' => Yii::app()->request->urlReferrer,
    'Pemeriksaan Pasien',
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
	<div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Pemeriksaan Pasien</div>
    </div>
    <div class="panel-body">
	<?php 
	$this->widget('bootstrap.widgets.BootAlert');
	$this->renderPartial($this->path_view.'_dataPasien',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien,'modAdmisi'=>$modAdmisi));
	$this->renderPartial($this->path_view.'_tabMenu',array('modPendaftaran'=>$modPendaftaran));
	$this->renderPartial($this->path_view.'_jsFunctions',array("modPasien"=>$modPasien)); ?>
	<div>
	<iframe id="frame" src="" style="width: 100%; overflow-y: scroll; border: none;"></iframe>
	</div>
    </div>
</div>
<?php //$this->renderPartial("rawatJalan.views.pemeriksaanPasien.validasi.handle-tab.index",[], true); ?>

<?php
//========= Dialog Detail Tindakan, Terapi dan Pemakaian Bahan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetailDataPenunjang',
    'options' => array(
        'title' => 'Detail Data',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1200,
        'height' => 700,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="detailDialogPenunjang" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetailRiwayat',
    'options' => array(
        'title' => 'Detail Data',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 500,
        'resizable' => false,
    ),
));
?>
<iframe frameborder="0" name="frameRiwayat" width="100%" height="700px"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

