<?php
$this->breadcrumbs = array(
    'Informasi Pasien Rawat Inap' => Yii::app()->request->getUrlReferrer(),
    'Pemeriksaan Pasien',
);

?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Asuhan Gizi
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->widget('bootstrap.widgets.BootAlert');
        
        $modul = Yii::app()->controller->module->id;

        if($modul == 'rawatInap') {
            $this->renderPartial($this->path_view . '_dataPasien', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'modAdmisi' => $modAdmisi));
        } else {
            $this->renderPartial($this->path_view . '_dataPasienRJ', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien));
        }
        $this->renderPartial($this->path_view . '_tabMenu', array());
        $this->renderPartial($this->path_view . '_jsFunctions', array("modPasien" => $modPasien)); ?>
        <div>
            <iframe class="biru" id="frame" src="" width='100%' frameborder="0" style="overflow-y:scroll; "></iframe>
        </div>
    </div>
</div>