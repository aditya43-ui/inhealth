<form class="form-horizontal">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="entypo-info-circled"></i> Informasi <b>Bedah</b>
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::label('Tgl. Operasi', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php
                            $diag = empty($rencana->tglrencanaoperasi) ? "" : MyFormatter::formatDateTimeForUser($rencana->tglrencanaoperasi);
                            echo CHtml::textField('tglrencanaoperasi', $diag, array('class' => 'span3', 'readonly' => true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Jam Mulai Operasi', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php
                            $diag = empty($rencana->mulaioperasi) ? "" : $rencana->mulaioperasi;
                            echo CHtml::textField('mulaioperasi', $diag, array('class' => 'span3', 'readonly' => true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Diagnosa Pra Bedah', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php
                            $diag = empty($diagnosa) ? "" : ($diagnosa->diagnosa->diagnosa_kode . " - " . $diagnosa->diagnosa->diagnosa_nama);
                            echo CHtml::textArea('diagnosa_prabedah', $diag, array('class' => 'span3', 'readonly' => true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Operasi yang dilakukan', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php
                            $val = (empty($rencana) || empty($rencana->operasi) || empty($rencana->operasi->kegiatanoperasi)) ? "" : ($rencana->operasi->kegiatanoperasi->kegiatanoperasi_nama);
                            echo CHtml::textField('jenis_operasi', $val, array('class' => 'span3', 'readonly' => true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Sifat Tindakan', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php
                            echo CHtml::textField('sifat_tindakan', $rencana->is_cyto ? "CITO" : "ELEKTIF", array('class' => 'span3', 'readonly' => true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Alergi', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php
                            echo CHtml::textField('alergi', empty($anamnesa) ? "" : $anamnesa->riwayatalergiobat, array('class' => 'span3', 'readonly' => true)); ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::label('Operator', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php
                            $val = (empty($rencana) || empty($rencana->dokter1)) ? "" : ($rencana->dokter1->namaLengkap);
                            echo CHtml::textField('dokter_operator', $val, array('class' => 'span5', 'readonly' => true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Asisten Operator', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php
                            $val = (empty($rencana) || empty($rencana->dokter2)) ? "" : ($rencana->dokter2->namaLengkap);
                            echo CHtml::textField('dokter_operator', $val, array('class' => 'span5', 'readonly' => true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Perawat 1', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php
                            $val = (empty($rencana) || empty($rencana->perawatsirkuler)) ? "" : ($rencana->perawatsirkuler->namaLengkap);
                            echo CHtml::textField('perawat_1', $val, array('class' => 'span5', 'readonly' => true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Perawat 2', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php
                            $val = (empty($rencana) || empty($rencana->bidan)) ? "" : ($rencana->bidan->namaLengkap);
                            echo CHtml::textField('perawat_2', $val, array('class' => 'span5', 'readonly' => true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Dokter Anestesiologi', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php
                            $val = (empty($anestesi) || empty($anestesi->dokteranastesi)) ? "" : ($anestesi->dokteranastesi->namaLengkap);
                            echo CHtml::textField('dokter_anestesiologi', $val, array('class' => 'span5', 'readonly' => true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Perawat Anestesiologi', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php
                            $val = (empty($anestesi) || empty($anestesi->perawatanastesi)) ? "" : ($anestesi->perawatanastesi->namaLengkap);
                            echo CHtml::textField('perawat_anestesiologi', $val, array('class' => 'span5', 'readonly' => true)); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>