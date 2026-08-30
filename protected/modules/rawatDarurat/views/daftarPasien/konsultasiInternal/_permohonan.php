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
                    <?= CHtml::textField('tglkonsulpoli', $model->tglkonsulpoli, array('class' => '', 'style' => 'text-align:left', 'readonly' => true)) ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Dokter Pengirim</label>
                <div class="controls">
                    <?php
                    $login = LoginpemakaiK::model()->findByPk($model->create_loginpemakai_id);
                    ?>
                    <?= CHtml::textField('create_loginpemakai_id', $login->pegawai->namaLengkap ?? "-", array('class' => '', 'style' => 'text-align:left', 'readonly' => true)) ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Uraian Konsul</label>
                <div class="controls">
                    <?= CHtml::textArea('uraian_konsul', $model->uraian_konsul ?? '', ['readonly' => true, 'rows' => 10, 'style' => 'width:500px !important']) ?>
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
                    <?= CHtml::textArea('tglkonsulpoli', $model->catatan_dokter_konsul, array('class' => '', 'style' => 'text-align:left', 'readonly' => true)) ?>
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
        <div class="col-sm-12">
            <div class="control-group">
                <div class="controls" style="width:80%;">
                    <?php echo CHtml::activeTextArea($model, 'uraian_konsul', array('style' => 'width: 960px; height: 200px; ', 'readonly' => true)); ?>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>