<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fa fa-stethoscope"></i> Pemeriksaan Pasien <b><?php echo Yii::app()->user->getState('ruangan_nama'); ?></b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Daftar Pasien' => Yii::app()->request->urlReferrer,
            'Pemeriksaan Pasien',
        );
        ?>
        <?php $this->renderPartial($this->path_view . '_dataPasien', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'modPasienMasukPenunjang' => $modPasienMasukPenunjang)); ?>
        <?php
        $this->renderPartial($this->path_view . '_tabMenu', array('modPendaftaran'=>$modPendaftaran));
        $this->renderPartial($this->path_view . '_jsFunctions', array("modPasien" => $modPasien)); ?>
        <div>
            <iframe class="biru" id="frame" src="" width='100%' frameborder="0" style="overflow-y:scroll; "></iframe>
        </div>
    </div>
</div>

<?php  // $this->renderPartial("rawatJalan.views.pemeriksaanPasien.validasi.handle-tab.index",[], true); ?>