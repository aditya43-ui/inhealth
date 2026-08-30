<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-check"></i> Verifikasi Keluar Ruang Pulih & Serah Terima Pasien
        </div>
    </div>
    <div class="panel-body">
        <?php echo $this->renderPartial('_infoPasien', array(
            'model' => $penunjang,
        ), true); ?>
        <?php echo $this->renderPartial('_infoRuangPulih', array(
            'model' => $model,
            'verifikasi' => $verifikasi,
            'penunjang' => $penunjang,
            'admisi' => $admisi,
            'anestesi' => $anestesi,
            'rencana' => $rencana,
            'skor' => $skor,
            'modelNyeri' => $modelNyeri,
        ), true); ?>
        <?php echo $this->renderPartial('_form', array(
            'verifikasi' => $verifikasi, 'model' => $model,
        ), true); ?>
    </div>
</div>