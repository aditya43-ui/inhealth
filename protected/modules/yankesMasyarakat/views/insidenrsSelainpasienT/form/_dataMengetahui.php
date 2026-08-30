<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label('Kepala Satuan Kerja / Pelapor <span class="required">*</span>', 'unitkerjapenyebab_id', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            echo CHtml::activeHiddenField($model, 'pegawai_mengetahui1_id', array('class' => 'span4', 'readonly' => true));
            $this->widget('MyJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'pegawai_mengetahui1_nama',
                'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . $this->createUrl('getPegawaiPelapor') . '",
                            dataType: "json",
                            data: {
                                term: request.term,
                            },
                            success: function (data) {
                                response(data);
                            }
                        })
                    }',
                'options' => array(
                    'showAnim' => 'fold',
                    'minLength' => 3,
                    'focus' => 'js:function(event, ui ) {
                            return false;
                        }',
                    'select' => 'js:function(event, ui ) {
                            $(this).val(ui.item.nama_pegawai);
                            $("#YKMInsidenrsSelainpasienT_pegawai_mengetahui2_id").val( ui.item.value );
                            return false;
                        }',
                ),
                'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)",  'class' => 'span4 required', 'placeholder' => 'Pilih Nama Kepala Satuan Kerja / Pelapor',
                ),
                 'tombolDialog'=>array('idDialog'=>'dialogKepalaSatuan','idTombol'=>'tombolDialogPenelitian'),
            ));?>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label('Ketua Tim K3 <span class="required">*</span>', 'unitkerjapenyebab_id', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            echo CHtml::activeHiddenField($model, 'pegawai_mengetahui2_id', array('class' => 'span4', 'readonly' => true));
            $this->widget('MyJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'pegawai_mengetahui2_nama',
                'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . $this->createUrl('getPegawaiK3') . '",
                            dataType: "json",
                            data: {
                                term: request.term,
                            },
                            success: function (data) {
                                response(data);
                            }
                        })
                    }',
                'options' => array(
                    'showAnim' => 'fold',
                    'minLength' => 3,
                    'focus' => 'js:function(event, ui ) {
                            return false;
                        }',
                    'select' => 'js:function(event, ui ) {
                            $(this).val(ui.item.nama_pegawai);
                            $("#YKMInsidenrsSelainpasienT_pegawai_mengetahui2_id").val( ui.item.value );
                            return false;
                        }',
                ),
                'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)",  'class' => 'span4 required', 'placeholder' => 'Pilih Nama Ketua Tim K3',
                ),
                 'tombolDialog'=>array('idDialog'=>'dialogKepalaK3','idTombol'=>'tombolDialogPenelitian'),
            ));?>
        </div>
    </div>
</div>