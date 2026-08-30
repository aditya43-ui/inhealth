<div class="col-md-6">
    <?php echo $form->textFieldRow($model, 'no_dokumen', array('readonly' => true, 'class' => 'span4 required', 'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Nomor Pelaporan')); ?>
    <?php echo $form->textFieldRow($model, 'no_revisi', array('readonly' => true, 'class' => 'span4 required', 'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Nomor Revisi')); ?>
    <div class="control-group">
        <?php echo CHtml::label("Tanggal Pelaporan <i style='color: red'> * </i>", "", array('class' => 'control-label')); ?>
        <div class="controls">
            <?php
            if (!empty($_GET['is_detail'])) {
                echo CHtml::activeTextField($model, 'tgl_pelaporan', array('class' => 'span4', 'readonly' => true));
            } else {
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tgl_pelaporan',
                    'mode' => 'datetime',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:200px;'
                    ),
                ));
            }
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Mengetahui <i style='color: red'> * </i>", '', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            echo CHtml::activeHiddenField($model, 'mengetahuipegawai_id', array('class' => 'span4', 'readonly' => true));
            if (!empty($_GET['is_edit']) || !empty($_GET['is_detail'])) {
                echo CHtml::activeTextField($model, 'mengetahuipegawai_nama', array('class' => 'span4', 'readonly' => true));
            } else {
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'mengetahuipegawai_nama',
                    'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . $this->createUrl('getPegawai') . '",
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
                            $("#YKMInsidentumpahanb3T_mengetahuipegawai_id").val( ui.item.value );
                            return false;
                        }',
                    ),
                    'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span4 required', 'placeholder' => 'Pilih Nama Pegawai',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogKepalaSatuan', 'idTombol' => 'tombolDialogPenelitian'),
                ));
            }
            ?>
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="control-group">
        <?php echo CHtml::label("Nama Pelapor <i style='color: red'> * </i>", '', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            echo CHtml::activeHiddenField($model, 'pelapor_id', array('class' => 'span4', 'readonly' => true));
            if (!empty($_GET['is_edit']) || !empty($_GET['is_detail'])) {
                echo CHtml::activeTextField($model, 'pelapor_nama', array('class' => 'span4', 'readonly' => true));
            } else {
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'pelapor_nama',
                    'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . $this->createUrl('getPegawai') . '",
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
                            $("#YKMInsidentumpahanb3T_pelapor_id").val( ui.item.value );
                            $("#YKMInsidentumpahanb3T_nomorindukpegawai").val( ui.item.nomorindukpegawai );
                            return false;
                        }',
                    ),
                    'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span4 required', 'placeholder' => 'Pilih Nama Pegawai',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPegawai', 'idTombol' => 'tombolDialogPenelitian'),
                ));
            }
            ?>
        </div>
    </div>
<?php echo $form->textFieldRow($model, 'nomorindukpegawai', array('readonly' => true, 'class' => 'span4 required', 'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Nomor Induk Pegawai')); ?>
    <?php echo $form->textFieldRow($model, 'saksi1', array('readonly' => false, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Ketikkan Nama Saksi yang Mengetahui Kejadian')); ?>
    <?php echo $form->textFieldRow($model, 'saksi2', array('readonly' => false, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Ketikkan Nama Saksi yang Mengetahui Kejadian')); ?>
    <?php echo $form->textFieldRow($model, 'saksi3', array('readonly' => false, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Ketikkan Nama Saksi yang Mengetahui Kejadian')); ?>
</div>