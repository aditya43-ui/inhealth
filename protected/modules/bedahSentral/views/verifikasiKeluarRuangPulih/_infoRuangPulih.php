<form class='form-info form-horizontal'>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="entypo-info-circled"></i> Informasi <b>Keluar Ruang Pulih</b>
            </div>
        </div>
        <div class="panel-body">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::activeLabel($model, 'keluarruanganpulih_tanggal', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::textField('keluarruanganpulih_tanggal', MyFormatter::formatDateTimeForUser(date('Y-m-d', strtotime($model->keluarruanganpulih_tanggal))), array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($model, 'keluarruanganpulih_jam', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::textField('keluarruanganpulih_jam', $model->keluarruanganpulih_jam, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($model, 'petugas_saatkeluarruangpulih_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::textField('petugas_saatkeluarruangpulih_id', empty($model->petugasSaatkeluarruangpulih) ? "-" : $model->petugasSaatkeluarruangpulih->namaLengkap, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modelNyeri, 'score_skalanyeri', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::textField('score_skalanyeri', $model->score_skalanyeri, array('readonly' => true, 'class' => 'span1', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modelNyeri, 'keteranganskala_nyeri', array('class' => 'control-label', 'label' => 'Keterangan Skala Nyeri')); ?>
                    <div class="controls">
                        <?php echo CHtml::textField('keteranganskala_nyeri', $model->keteranganskala_nyeri, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <br>
                <div class="panel panel-dark">
                    <span class="group-title">
                        Tindak Lanjut Pasien
                    </span>
                    <div class="panel-body">
                        <?php
                        $instalasi = "-";
                        $ruangan = "-";
                        $kamar = "-";
                        $modKamar = $model->tindaklanjutpasienKamarruangan;
                        if (!empty($modKamar)) {
                            $ruangan = $modKamar->ruangan->ruangan_nama;
                            $instalasi = $modKamar->ruangan->instalasi->instalasi_nama;
                            $kamar = $modKamar->kamarruangan_nokamar . " - BED " . $modKamar->kamarruangan_nobed;
                        }
                        ?>
                        <div class="control-group">
                            <?php echo CHtml::activeLabel($model, 'tindaklanjutpasien', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo CHtml::textField('tindaklanjutpasien', $model->tindaklanjutpasien, array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::activeLabel($model, 'instalasi', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo CHtml::textField('instalasi_id', $instalasi, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::activeLabel($model, 'ruangan', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo CHtml::textArea('ruangan', $ruangan . " / " . $kamar, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
            <div class="col-sm-6">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">Skor Aldrette</div>
                    </div>
                    <div class="panel-body">
                        <?php
                        echo $this->renderPartial("_skor", array(
                            'model' => $model,
                            'skor' => $skor,
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            Catatan Khusus Ruang Pulih
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php
                        echo $this->renderPartial("_catatan", array(
                            'model' => $model,
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class='clear'></div>
            <div class='col-sm-12'>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            Instruksi Dokter Pasca Anestesi
                        </div>
                    </div>
                    <div class="panel-body">
                        <table class='table table-bordered table-soldered'>
                            <tr>
                                <td width="150">Bila Nyeri</td>
                                <td><?php echo $model->instruksi_bilanyeri; ?></td>
                            </tr>
                            <tr>
                                <td>Mual/Muntah</td>
                                <td><?php echo $model->intruksi_mualmuntah; ?></td>
                            </tr>
                            <tr>
                                <td>Infus</td>
                                <td><?php echo $model->instruksi_infus; ?></td>
                            </tr>
                            <tr>
                                <td>Makan/Minum</td>
                                <td><?php echo $model->instruksi_makanminum; ?></td>
                            </tr>
                            <tr>
                                <td>Obat</td>
                                <td><?php echo $model->instruksi_obat; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>