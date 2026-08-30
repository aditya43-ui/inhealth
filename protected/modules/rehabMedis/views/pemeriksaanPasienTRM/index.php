<?php

/**
 * view utama untuk menampilkan interface dan form menu pemeriksaan pasien
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://piindonesia.co.id>
 */
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Pemeriksaan Pasien <b><?php echo $modPendaftaran->ruangan->ruangan_nama; ?></b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Daftar Pasien' => Yii::app()->request->getUrlReferrer(),
            'Pemeriksaan Pasien',
        );
        ?>
        <?php
        $this->renderPartial($this->path_view . '_dataPasien', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien));
        $this->renderPartial('_tabMenu', array());
        $this->renderPartial('_jsFunctions', array("modPasien" => $modPasien)); ?>
        <div>
            <iframe id="frame" src="" style="width: 100%; overflow-y: scroll; border: none;"></iframe>
        </div>
    </div>
</div>

<?= $this->renderPartial("rawatJalan.views.pemeriksaanPasien.validasi.handle-tab.index",[], true); ?>
