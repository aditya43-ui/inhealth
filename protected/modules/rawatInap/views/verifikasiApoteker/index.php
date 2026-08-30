<?php
$this->breadcrumbs = array(
    'Informasi Pasien Rawat Inap' => Yii::app()->request->getUrlReferrer(),
    'Verifikasi Apoteker',
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
            <i class="fa fa-stethoscope"></i> Verifikasi Apoteker
        </div>
    </div>
    <div class="panel-body" style="padding-top: 0;">
        <?php $this->widget('bootstrap.widgets.BootAlert');
        $this->renderPartial($this->path_view . '_dataPasien', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'modAdmisi' => $modAdmisi)); ?>
        <?php
        $this->renderPartial($this->path_view . '_tabMenu', array('modPendaftaran' => $modPendaftaran));
        $this->renderPartial($this->path_view . '_jsFunctions', array("modPasien" => $modPasien, 'modPendaftaran'=>$modPendaftaran)); ?>
        <div class="frameTabulasi">
            <iframe class="biru" id="frame" src="" width='100%' frameborder="0" style="overflow-y:scroll; "></iframe>
        </div>
    </div>
</div>

<?php // $this->renderPartial("rawatJalan.views.pemeriksaanPasien.validasi.handle-tab.index",[], true); ?>