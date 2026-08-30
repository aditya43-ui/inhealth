<?php

/**
 * @author Aida Rahmawati <aidarahmawati@.com>
 */
?>
<?php
$this->breadcrumbs = array(
    'Informasi Pasien MCU' => Yii::app()->request->getUrlReferrer(),
    'Data Riwayat Pemeriksaan'
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Data <b> Riwayat Pemeriksaan </b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial('_dataPasien', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien)); ?>
        <?php $this->renderPartial($this->path_view . '/_tabMenu', array('modPendaftaran' => $modPendaftaran,)); ?>
    </div>
</div>