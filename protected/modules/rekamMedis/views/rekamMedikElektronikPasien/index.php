<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Rekam Medis Elektronik Pasien <b> : <span id="textpanel"></span></b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Daftar Pasien' => Yii::app()->request->urlReferrer,
            ' Berkas Rekam Medis Elektronik Pasien',
        );
        ?>
        <?php
        $this->renderPartial($this->path_view . '_dataPasien', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'pages'=>$pages,'modKunjungan'=>$modKunjungan, 'modPenunjang' => $modPenunjang));
        $this->renderPartial($this->path_view . '_tabMenu', array());
        $this->renderPartial($this->path_view . '_jsFunctions', array("modPasien" => $modPasien)); ?>
        <div>
            <iframe id="frame" src="" style="width: 100%; overflow-y: scroll; border: none;"></iframe>
        </div>
    </div>
</div>