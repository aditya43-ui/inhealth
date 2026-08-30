<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Pemeriksaan Golongan Darah (Metode Tube Test)</div>
    </div>
    <div class="panel-body">
<?php

$peg = "";
if (!empty($pengujianTube)) {
    $pegawai = PegawaiM::model()->findByPk($pengujianTube->peg_pemeriksa_id);
    $peg = $pegawai->namaLengkap;
}

?>

        <div class="control-group">
            <label class="control-label">Waktu Pengujian</label>
            <div class="controls">
                <?php echo CHtml::textField('tube_waktu', MyFormatter::formatDateTimeForUser($pengujianTube->tglujidarahpasien), array('readonly'=>true)); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Nama Penguji</label>
            <div class="controls">
                <?php echo CHtml::textField('tube_penguji', $peg, array('readonly'=>true)); ?>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        Cell Grouping
                    </div>
                </div>
                <div class="panel-body">
                    <div class="control-group">
                        <label class="control-label">Anti A</label>
                        <div class="controls">
                            <?php echo CHtml::textField('tube_anti_a', $pengujianTube->anti_a, array('readonly'=>true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Anti B</label>
                        <div class="controls">
                            <?php echo CHtml::textField('tube_anti_b', $pengujianTube->anti_b, array('readonly'=>true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Anti AB</label>
                        <div class="controls">
                            <?php echo CHtml::textField('tube_anti_ab', $pengujianTube->anti_ab, array('readonly'=>true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Anti D</label>
                        <div class="controls">
                            <?php echo CHtml::textField('tube_anti_d', $pengujianTube->anti_d, array('readonly'=>true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Kesimpulan</label>
                        <div class="controls">
                            <?php echo CHtml::textArea('tube_anti_kesimpulan', $pengujianTube->kesimpulan_uji, array('readonly'=>true)); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        Serum Typing
                    </div>
                </div>
                <div class="panel-body">
                    <div class="control-group">
                        <label class="control-label">Test Cell A</label>
                        <div class="controls">
                            <?php echo CHtml::textField('tube_test_a', $pengujianTube->sel_a, array('readonly'=>true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Test Cell A</label>
                        <div class="controls">
                            <?php echo CHtml::textField('tube_test_b', $pengujianTube->sel_b, array('readonly'=>true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Test Cell O</label>
                        <div class="controls">
                            <?php echo CHtml::textField('tube_test_o', $pengujianTube->sel_o, array('readonly'=>true)); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clear"></div>

    </div>
</div>