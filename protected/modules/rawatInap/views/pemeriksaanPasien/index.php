<?php
$this->breadcrumbs = array(
    'Informasi Pasien Rawat Inap' => Yii::app()->request->getUrlReferrer(),
    'Pemeriksaan Pasien',
);
?>

<style>
    .accordion-inner iframe {
        width: 100%;
    }
</style>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fa fa-stethoscope"></i> Pemeriksaan Pasien
        </div>
    </div>
    <div class="panel-body" style="padding-top: 0;">
        <?php $this->widget('bootstrap.widgets.BootAlert');
        $this->renderPartial($this->path_view . '_dataPasien', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'modAdmisi' => $modAdmisi)); ?>
        <?php
        $this->renderPartial($this->path_view . '_tabMenu', array('modPendaftaran' => $modPendaftaran));
        $this->renderPartial($this->path_view . '_jsFunctions', array("modPasien" => $modPasien, 'modPendaftaran'=>$modPendaftaran)); ?>
        <div>
            <iframe class="biru" id="frame" src="" width='100%' frameborder="0" style="overflow-y:scroll; "></iframe>
        </div>
    </div>
</div>

<?php // $this->renderPartial("rawatJalan.views.pemeriksaanPasien.validasi.handle-tab.index",[], true); ?>
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