<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Data <b>Permohonan Konsultasi</b>
        </div>
    </div>
    <div class="panel-body form-horizontal">
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">Tanggal dan Jam Konsul</label>
                <div class="controls">
                    <?= CHtml::textField('tglordertindakan', $model->tglordertindakan, array('class' => '', 'style' => 'text-align:right', 'readonly' => true)) ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Dokter Pengirim</label>
                <div class="controls">
                    <?= CHtml::textField('tglordertindakan', !empty($model->pegawai_id) ? PegawaiM::model()->findByPk($model->pegawai_id)->namaLengkap : "", array('class' => '', 'style' => 'text-align:left', 'readonly' => true)) ?>
                </div>
            </div>
        </div>
        <?php 
        if(Yii::app()->user->getState('modul_id') != Params::MODUL_ID_RJ){
        ?>
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">Keterangan Klinik</label>
                <div class="controls">
                    <?= CHtml::textArea('tglordertindakan', $model->catatan_dokter_ordertindakan, array('class' => '', 'style' => 'text-align:left', 'readonly' => true)) ?>
                </div>
            </div>
        </div>
        <?php } ?>
        <div class="clear"></div>
        <?php 
        if(Yii::app()->user->getState('modul_id') != Params::MODUL_ID_RJ){
        ?>
        <div class="col-sm-12">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">Riwayat Diagnosa</div>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Tanggal Diagnosa</th>
                                <th>Kelompok Diagnosa</th>
                                <th>Kode</th>
                                <th>Nama Diagnosa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (count((array)$pasienMorbiditas) > 0) {
                                foreach ($pasienMorbiditas as $key => $value) {
                                    echo "
                                        <tr>
                                            <td>" . MyFormatter::formatDateTimeForUser($value->tglmorbiditas) . "</td>
                                            <td>" . $value->kelompokdiagnosa->kelompokdiagnosa_nama . "</td>
                                            <td>" . $value->diagnosa->diagnosa_kode . "</td>
                                            <td>" . $value->diagnosa->diagnosa_nama . "</td>
                                        </tr>
                                    ";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
    <?php 
    if(Yii::app()->user->getState('modul_id') == Params::MODUL_ID_RJ){
    ?>
    <div class="panel-body form-horizontal" id="rm-tag">
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">Subjective</label>
                <div class="controls">
                    <?= CHtml::textArea('tglordertindakan', preg_replace('#</?p.*?>#is', '', $model->subjective), array('class' => '', 'style' => 'text-align:left', 'readonly' => true)) ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Objective</label>
                <div class="controls">
                    <?= CHtml::textArea('tglordertindakan', preg_replace('#</?p.*?>#is', '', $model->objective), array('class' => '', 'style' => 'text-align:left', 'readonly' => true)) ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">Assesment</label>
                <div class="controls">
                    <?= CHtml::textArea('tglordertindakan', preg_replace('#</?p.*?>#is', '', $model->assessment), array('class' => '', 'style' => 'text-align:left', 'readonly' => true)) ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Planning</label>
                <div class="controls">
                    <?= CHtml::textArea('tglordertindakan', preg_replace('#</?p.*?>#is', '', $model->planning), array('class' => '', 'style' => 'text-align:left', 'readonly' => true)) ?>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>