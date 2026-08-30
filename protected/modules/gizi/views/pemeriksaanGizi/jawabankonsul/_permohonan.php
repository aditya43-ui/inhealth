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
                    <?= CHtml::textField('tglkonsulpoli', $model->tglkonsulpoli, array('class' => '', 'style' => 'text-align:right', 'readonly' => true)) ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Dokter Pengirim</label>
                <div class="controls">
                    <?= CHtml::textField('tglkonsulpoli', !empty($model->pegawai_id) ? PegawaiM::model()->findByPk($model->pegawai_id)->namaLengkap : "", array('class' => '', 'style' => 'text-align:left', 'readonly' => true)) ?>
                </div>
            </div>
        </div>
      
        <div class="clear"></div>
        
    </div>
   
    <div class="panel-body form-horizontal" id="rm-tag">
        <div class="col-sm-12">
            <div class="control-group">
                <div class="controls" style="width:80%;">
                    <?php echo CHtml::activeTextArea($model, 'uraian_konsul', array('style' => 'width: 960px; height: 200px; ', 'readonly' => true)); ?>
                </div>
            </div>
        </div>
    </div>

</div>