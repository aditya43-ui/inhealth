<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Pemeriksaan Golongan Darah (Metode Slide Test)</div>
    </div>
    <div class="panel-body">
<?php

$peg = "";

if (!empty($pengujianSlide)) {
    $pegawai = PegawaiM::model()->findByPk($pengujianSlide->peg_pemeriksa_id);
    $peg = $pegawai->namaLengkap;
}

?>

        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">Waktu Pengujian</label>
                <div class="controls">
                    <?php echo CHtml::textField('tube_waktu', MyFormatter::formatDateTimeForUser($pengujianSlide->tglujidarahpasien), array('readonly'=>true)); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Nama Penguji</label>
                <div class="controls">
                    <?php echo CHtml::textField('tube_penguji', $peg, array('readonly'=>true)); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Anti A</label>
                <div class="controls">
                    <?php echo CHtml::textField('tube_anti_a', $pengujianSlide->anti_a, array('readonly'=>true)); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Anti B</label>
                <div class="controls">
                    <?php echo CHtml::textField('tube_anti_b', $pengujianSlide->anti_b, array('readonly'=>true)); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Anti D</label>
                <div class="controls">
                    <?php echo CHtml::textField('tube_anti_d', $pengujianSlide->anti_d, array('readonly'=>true)); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">Kesimpulan</label>
                <div class="controls">
                    <?php echo CHtml::textArea('tube_anti_kesimpulan', $pengujianSlide->kesimpulan_uji, array('readonly'=>true)); ?>
                </div>
            </div>
        </div>
        <div class="clear"></div>

    </div>
</div>