<style type="text/css">
    .text-center {
        text-align: center !important;
    }
</style>
<?php
if (Yii::app()->user->getState("ruangan_id") == 59) {
    $this->breadcrumbs = array(
        'Informasi Rekonsiliasi Obat' => Yii::app()->createUrl('/farmasiApotek/InformasiRekonObatPelayanan/index'),
        'Rekonsiliasi Obat',
    );
} else {
    $this->breadcrumbs = array(
        'Rekonsiliasi Obat',
    );
}
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> <b>Rekonsiliasi Obat</b>
            <span style="float: right !important;">
                <?php
                if (Yii::app()->user->getState("ruangan_id") == 59) {
                    if (!empty(Yii::app()->request->urlReferrer)) {
                        echo CHtml::link('<i class="entypo-back" style="color: white;"></i> Kembali', Yii::app()->request->urlReferrer, array('class' => 'btn btn-red', 'style' => 'color: white;'));
                    }
                } ?>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial($this->path_view . '_dataPasien', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien)); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> <b>Riwayat Rekonsiliasi Obat</b></div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view . '_riwayat', array('modPendaftaran' => $modPendaftaran)); ?>
            </div>
        </div>
        <?php $this->renderPartial($this->path_view . '_tabMenu', array()); ?>
        <div>
            <iframe id="frame" src="" width='100%' frameborder="0" style="overflow-y:scroll; overflow-x: scroll;"></iframe>
        </div>
    </div>
</div>
<?php $this->renderPartial($this->path_view . '_jsFunctionsTabulasi', array("modPasien" => $modPasien, 'modPendaftaran' => $modPendaftaran)); ?>